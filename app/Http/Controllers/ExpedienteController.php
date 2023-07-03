<?php

namespace App\Http\Controllers;

use App\Http\Requests\DerivarRequest;
use App\Http\Requests\ExpedienteRequest;
use App\Http\Requests\FinalizarRequest;
use App\Models\Accion;
use App\Models\Admin;
use App\Models\Archivo;
use App\Models\Documento;
use App\Models\Expediente;
use App\Models\ExpedienteArchivo;
use App\Models\Oficina;
use App\Models\Proceso;
use App\Models\Tramite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Illuminate\Support\Str;


class ExpedienteController extends Controller
{
    protected $expediente;
    protected $admin;
    public function __construct()
    {
        $this->expediente = new Expediente();

        $this->middleware(function ($request, $next) {
            $this->admin =  Auth::guard('admin')->user();
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        $data = Expediente::getPendientes($request, $this->admin);
        return Inertia::render('Admin/Expediente/index', $data);
    }

    public function internos(Request $request)
    {
        $data = Expediente::getExpedientes($request, ['JEFATURA', 'PERSONAL'], $this->admin);
        return Inertia::render('Admin/Expediente/internos', $data);
    }

    public function externos(Request $request)
    {
        $data = Expediente::getExpedientes($request, ['EXTERNO'], $this->admin);
        return Inertia::render('Admin/Expediente/externos', $data);
    }

    public function derivados(Request $request)
    {
        $data = Expediente::getDerivados($request, $this->admin);
        return Inertia::render('Admin/Expediente/derivados', $data);
    }

    public function archivados(Request $request)
    {
        $data = Expediente::getArchivados($request, $this->admin);
        return Inertia::render('Admin/Expediente/archivados', $data);
    }

    public function finalizados(Request $request)
    {
        $data = Expediente::getFinalizados($request, $this->admin);
        return Inertia::render('Admin/Expediente/finalizados', $data);
    }

    public function observados(Request $request)
    {
        $data = Expediente::getObservados($request, $this->admin);
        return Inertia::render('Admin/Expediente/observados', $data);
    }



    public function show($tramite)
    {

        $tramite = Expediente::getTramite($tramite);
        return Inertia::render(
            'Admin/Expediente/show',
            ['tramite' => $tramite, 'oficinas' => Oficina::all(), 'acciones' => Accion::all()]
        );
    }

    public function create(String $tipo)
    {
        if ($tipo === 'EXTERNO' || $tipo === 'externo') {

            return Inertia::render('Admin/Expediente/create', [
                'procesos' => Proceso::all(),
                'documentos' => Documento::all(),
                'oficinas' => Oficina::all(),
                'siglas' => '',
                'periodo' => '2023',
                'tipo' => $tipo,
                'externo' => true,
            ]);
        }

        return Inertia::render('Admin/Expediente/create', [
            'procesos' => Proceso::all(),
            'documentos' => Documento::all(),
            'oficinas' => Oficina::all(),
            'siglas' => $this->expediente->getSiglas($tipo),
            'periodo' => '2023',
            'tipo' => $tipo,
            'externo' => false,
        ]);
    }

    public function store(ExpedienteRequest $request)
    {
        $data = $request->all();
        $data['expe_password'] =  Str::random(10);

        $expediente = Expediente::create($data);

        foreach ($data['destinatarios'] as $destino) {
            $this->storeTramite($destino, $expediente);
        }

        $expeCodigo = '001-' .  $expediente->expe_periodo .  str_pad($expediente->expe_id, 7, "0", STR_PAD_LEFT) . substr($expediente->expe_tipo, 0, 1);
        $expediente->expe_codigo =  $expeCodigo;
        $expediente->save();

        $this->saveFilesExpediente($request, $expediente);

        return redirect()->back()->with('success', 'Elemento creado exitosamente.');
    }

    public function storeTramite($destino, $expediente)
    {

        foreach ($destino['para'] as $para) {
            $tramite = [
                'tram_esta_id' => 5, //pendiente,
                'tram_fecha_registro' => date('Y-m-d H:i:s'),
                'tram_fecha_tramitado' => date('Y-m-d H:i:s'),
                'tram_periodo'  => $expediente->expe_periodo,
                'tram_expe_id' => $expediente->expe_id,
                'tram_ofic_ini' => $expediente->expe_ofic_id,
                'tram_docu_id' => $expediente->expe_docu_id,
                'tram_admin_ini' => $expediente->expe_admin_id,
                'tram_ofic_fin' => $destino['ofic_id'],
                'tram_admin_fin' => $para,
                'tram_acci_id' => $destino['tram_acci_id'] ?? null,
            ];
            Tramite::create($tramite);
        }
    }

    public function recibir(Request $request)
    {
        $tramite = Tramite::find($request->tramite);
        $tramite->tram_esta_id = 6; //recibido
        $tramite->tram_fecha_recibido = date('Y-m-d H:i:s');

        $tramite->save();

        return redirect()->back()->with('success', 'Operacion Exitosa.');
    }

    public function observar(Request $request)
    {

        $tramite = Tramite::find($request->tramite);
        $tramite->tram_esta_id = 10; //observado
        $tramite->tram_observacion = $request->observacion;
        $tramite->tram_notificar = $request->notificar;
        $tramite->save();

        $expediente = Expediente::find($tramite->tram_expe_id);
        $expediente->expe_esta_id = 3; //observado
        $expediente->expe_observacion = $request->observacion;
        $expediente->save();

        return redirect()->back()->with('success', 'Operacion Exitosa.');
    }

    public function archivar(Request $request)
    {

        $tramite = Tramite::find($request->tramite);
        $tramite->tram_esta_id = 9; //archivado
        $tramite->tram_observacion = $request->observacion;
        $tramite->tram_notificar = $request->notificar;
        $tramite->save();

        return redirect()->back()->with('success', 'Operacion Exitosa.');
    }

    public function finalizar(FinalizarRequest $request)
    {

        if ($request->hasFile('archivo')) {
            $indexArchivo = 1;
            foreach ($request->archivo as $expeArchivo) {
                $archivo = $this->saveFile($expeArchivo, 'R' . $indexArchivo . '-' . $request->codigo);
                $this->storeExpedienteArchivo('RESPUESTA', $request->expediente, $archivo, $request->tramite);
                $indexArchivo++;
            }
        }

        $tramite = Tramite::find($request->tramite);
        $tramite->tram_esta_id = 8; //finalizado
        $tramite->tram_observacion = $request->observacion;
        $tramite->tram_notificar = $request->notificar;
        $tramite->save();

        $expediente = Expediente::find($tramite->tram_expe_id);
        $expediente->expe_esta_id = 4; //finalizado
        $expediente->save();

        return redirect()->back()->with('success', 'Operacion Exitosa.');
    }

    public function derivar(DerivarRequest $request)
    {

        $expediente = Expediente::find($request->expediente);

        foreach ($request['destinatarios'] as $destino) {
            $destino['tram_acci_id'] = $request->accion;
            $destino['tram_observacion'] = $request->observacion;
            $this->storeTramite($destino, $expediente);
        }

        $tramite = Tramite::find($request->tramite);
        $tramite->tram_esta_id = 7; //finalizado
        $tramite->tram_notificar = $request->notificar;
        $tramite->save();

        if ($request->hasFile('archivo')) {
            $indexArchivo = 1;
            foreach ($request->archivo as $expeArchivo) {
                $archivo = $this->saveFile($expeArchivo, 'AD' . $indexArchivo . '-' . $request->codigo);
                $this->storeExpedienteArchivo('ADJUNTO', $request->expediente, $archivo, $request->tramite);
                $indexArchivo++;
            }
        }

        return redirect()->back()->with('success', 'Operacion Exitosa.');
    }



    // *MIS TRAMITES
    public function indexEmitidos(Request $request)
    {

        $perPage = $request->input('perPage', 10);
        $query = Expediente::query();

        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where('expe_codigo', 'like', '%' . $searchTerm . '%');
        }

        $items = $query->where('expe_admin_id', $this->admin->id)->paginate($perPage)->appends($request->query());

        return Inertia::render('Admin/Expediente/emitidos', [
            'items' => $items,
            'headers' => Expediente::$headers,
            'filters' => [
                'search' => $request->search,
            ],
        ]);
    }

    // *FUNCIONES
    public function getAdminsByOfic($oficina)
    {

        $admin = Admin::where('ofic_id', $oficina)->where('id', '!=', $this->admin->id)->get();

        return response()->json($admin);
    }

    function getNextNumDocumento(Request $request)
    {
        $nextNum =  $this->expediente->getNextNumDoc($request->docu, $request->tipo, $request->sigla);

        return response()->json($nextNum);
    }

    function storeExpedienteArchivo($tipo, $expediente, $archivo, $tramite = null)
    {

        ExpedienteArchivo::create([
            'exar_tipo' => $tipo,
            'exar_url' =>   $archivo->arch_path,
            'exar_expe_id' => $expediente,
            'exar_arch_id' => $archivo->arch_id,
            'exar_tram_id' => $tramite,
        ]);
    }

    function saveFilesExpediente($request, $expediente)
    {
        $expeArchivos = $request['expe_archivo'];
        $expeAnexos = $request['expe_anexos'] ?? [];

        foreach ($expeArchivos as $expeArchivo) {
            $archivo = $this->saveFile($expeArchivo, $expediente->expe_codigo);

            $this->storeExpedienteArchivo('PRINCIPAL', $expediente->expe_id, $archivo);
        }

        $indexAnexo = 1;
        foreach ($expeAnexos as $expeAnexo) {
            $anexo = $this->saveFile($expeAnexo, 'A' . $indexAnexo . '-' . $expediente->expe_codigo);
            $this->storeExpedienteArchivo('ANEXO', $expediente->expe_id, $anexo);
            $indexAnexo++;
        }
    }

    function saveFile($file, $name)
    {

        $tamanio = $file->getSize();
        $mimeType = $file->getClientMimeType();
        $extension = $file->getClientOriginalExtension();

        $fileName = '' . $name . '.' . $file->getClientOriginalExtension();

        Storage::disk('file')->put($fileName, file_get_contents($file));

        return Archivo::create([
            'arch_nombre' => $fileName,
            'arch_path' => Storage::disk('file')->url($fileName),
            'arch_extencion' => $extension,
            'arch_tamanio' => $tamanio,
            'arch_mimetype' => $mimeType,
        ]);
    }
}
