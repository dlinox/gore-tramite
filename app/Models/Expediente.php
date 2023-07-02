<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Expediente extends Model
{
    use HasFactory;

    protected $primaryKey = 'expe_id';
    public $timestamps = true;

    protected $fillable = [
        'expe_codigo',
        'expe_password',
        'expe_origen',
        'expe_numero',
        'expe_periodo',
        'expe_sigla',
        'expe_tipo',
        'expe_asunto',
        'expe_resumen',
        'expe_folios',
        'expe_observacion',
        'expe_fecha_registro',
        'expe_plazo',
        'expe_remi_tipo',
        'expe_esta_id',
        'expe_proc_id',
        'expe_docu_id',
        'expe_admin_id',
        'expe_pers_id',
        'expe_ofic_id'
    ];

    protected $casts = [
        'expe_tipo' => 'string',
        'expe_origen' => 'integer',
        'expe_numero' => 'integer',
        // 'expe_fecha_registro' => 'datetime',
        'expe_remi_tipo' => 'string',
        'expe_esta_id' => 'integer',
        'expe_proc_id' => 'integer',
        'expe_docu_id' => 'integer',
        'expe_admin_id' => 'integer',
        'expe_plazo' => 'integer',
        'expe_pers_id' => 'integer',

    ];

    protected $appends = [
        'tram_ofic_ini_nombre',
        // 'tram_admin_ini_nombre',
        'tram_ofic_fin_nombre',
        // 'tram_admin_fin_nombre',
        'tram_esta_nombre'
    ];

    /**
     * PROPIEDADES CASTS 
     */
    protected function getTramOficIniNombreAttribute()
    {
        return $this->tram_ofic_ini ? Oficina::find($this->tram_ofic_ini)->ofic_nombre : '-';
    }

    protected function getTramOficFinNombreAttribute()
    {
        return $this->tram_ofic_fin ? Oficina::find($this->tram_ofic_fin)->ofic_nombre :  '-';
    }

    protected function getTramEstaNombreAttribute()
    {
        return $this->tram_esta_id ? Estado::find($this->tram_esta_id)->esta_nombre : null;
    }

    protected function expeFechaRegistro(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value)->translatedFormat('F d \d\e\l Y')
        );
    }

    /**
     * PROPIEDADES CASTS DE TRAMITE 
     */

    protected  function tramFechaRegistro(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value)->translatedFormat('F d \d\e\l Y')
        );
    }

    protected  function tramFechaRecibido(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value)->translatedFormat('F d \d\e\l Y')
        );
    }



    /**
     *  RELACIONES
     */

    public function estado()
    {
        return $this->belongsTo(Estado::class, 'expe_esta_id', 'esta_id')->select('esta_id', 'esta_nombre');
    }

    public function proceso()
    {
        return $this->belongsTo(Proceso::class, 'expe_proc_id', 'proc_id')->select('proc_id', 'proc_nombre', 'proc_plazo');
    }

    public function documento()
    {
        return $this->belongsTo(Documento::class, 'expe_docu_id', 'docu_id')->select('docu_id', 'docu_nombre');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'expe_admin_id')->select('id', 'name', 'email', 'ofic_name', 'rol_name');
    }

    public function persona()
    {
        return $this->belongsTo(Persona::class, 'expe_pers_id', 'pers_id')->select('pers_id', 'pers_nombre', 'pers_paterno', 'pers_materno', 'pers_dni', 'pers_correo', 'pers_celular');
    }

    public function tramites()
    {
        return $this->hasMany(Tramite::class, 'tram_expe_id', 'expe_id');
    }

    public function archivos()
    {
        return $this->hasMany(ExpedienteArchivo::class, 'exar_expe_id', 'expe_id');
    }

    public static  $headers =  [
        ['text' => "Tramite", 'value' => "expe_proc_id", 'short' => false, 'order' => 'ASC'],
        ['text' => "Asunto", 'value' => "expe_asunto", 'short' => false, 'order' => 'ASC'],
        ['text' => "Resumen", 'value' => "expe_resumen", 'short' => false, 'order' => 'ASC'],
        ['text' => "Remitente", 'value' => "expe_pers_id", 'short' => false, 'order' => 'ASC'],
        ['text' => "Estado", 'value' => "tram_esta_nombre", 'short' => false, 'order' => 'ASC'],
        ['text' => "Fecha", 'value' => "tram_fecha_registro", 'short' => false, 'order' => 'ASC'],
    ];

    public static function getPendientes(Request $request, Admin $admin = null)
    {
        $perPage = $request->input('perPage', 10);
        $query = self::query();

        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where('expe_codigo', 'like', '%' . $searchTerm . '%');
        }

        $items = $query
            ->select(
                'expe_id',
                'expe_codigo',
                'expe_origen',
                'expe_asunto',
                'expe_resumen',
                'expe_esta_id',
                'expe_proc_id',
                'expe_docu_id',
                'expe_pers_id',

                'tram_id',
                'tram_ofic_fin',
                'tram_ofic_ini',
                'tram_esta_id',
                'tram_fecha_registro',
                'tram_periodo'
            )
            ->join('tramites', 'tram_expe_id', 'expe_id')
            ->where('tram_admin_fin', $admin->id)
            ->with(['persona', 'estado', 'proceso', 'documento'])
            ->paginate($perPage)->appends($request->query());

        return [
            'items' => $items,
            'headers' => self::$headers,
            'filters' => [
                'search' => $request->search,
            ],
        ];
        // return self::all();
    }

    public static function getTramite($tramite)
    {
        $query = self::query();
        $item = $query
            ->select(
                'expe_id',
                'expe_codigo',
                'expe_origen',
                'expe_asunto',
                'expe_resumen',
                'expe_esta_id',
                'expe_proc_id',
                'expe_docu_id',
                'expe_pers_id',
                'expe_tipo',
                'expe_numero',
                'expe_periodo',
                'expe_sigla',
                'expe_admin_id',
                'expe_fecha_registro',
                'expe_folios',
                'expe_remi_tipo',

                'tram_id',
                'tram_ofic_fin',
                'tram_ofic_ini',
                'tram_esta_id',
                'tram_fecha_registro',
                'tram_fecha_recibido',
                'tram_periodo'
            )
            ->join('tramites', 'tram_expe_id', 'expe_id')
            ->where('tram_id', $tramite)
            ->with(['persona', 'estado', 'proceso', 'documento', 'admin', 'archivos'])
            ->first();
        return  $item;
    }

    public function getNextNumDoc($doc, $tipo, $sigla)
    {
        $config = Configuracion::find(1);
        $periodo = $config->conf_periodo;
        $tipo = strtoupper($tipo);

        $origen  = $tipo === 'EXTERNO' ? 0 : 1;

        $res =  Expediente::where('expe_docu_id', $doc)
            ->where('expe_origen', $origen)
            ->where('expe_tipo', $tipo)
            ->where('expe_periodo', $periodo)
            ->where('expe_sigla', $sigla)
            ->max('expe_numero');

        return $res  + 1;
    }

    public function getSiglas(String $tipo, Admin $remitente = null): String
    {

        $admin = Auth::guard('admin')->user();

        $sigla = "";
        $siglas = [];

        if ($tipo === 'personal') {
            $_oficina = Oficina::select('ofic_siglas')->where('ofic_id', $admin->ofic_id)->first()->ofic_siglas;
            array_push($siglas, $_oficina, $this->getIniciales($admin->name));
        } else if ($tipo === 'jefatura') {
            $_oficina = Oficina::select('ofic_siglas')->where('ofic_id', $admin->ofic_id)->first()->ofic_siglas;
            array_push($siglas, $_oficina);
        }

        $sigla = implode('/', $siglas);
        return $sigla;
    }

    function getIniciales(String $string): String
    {
        $iniciales = '';
        $explode = explode(' ', $string);
        foreach ($explode as $val) {
            $iniciales .=  $val[0];
        }
        return $iniciales;
    }
}
