<?php

namespace App\Http\Controllers;

use App\Http\Requests\DocumentoRequest;
use App\Models\Documento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class DocumentoController extends Controller
{
    protected $documento;
    public function __construct()
    {
        $this->documento = new Documento();
    }

    public function index(Request $request)
    {

        $perPage = $request->input('perPage', 10);
        $query = Documento::query();

        // Búsqueda por el campo de busqueda
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where('docu_nombre', 'like', '%' . $searchTerm . '%');
        }

        // Obtener resultados paginados
        $items = $query->paginate($perPage)->appends($request->query());

        return Inertia::render('Admin/Documento/index', [
            'items' => $items,
            'headers' => $this->documento->headers,
            'filters' => [
                'search' => $request->search,
                //mas filtros
            ],
        ]);
    }

    public function store(DocumentoRequest $request)
    {
        if ($request->docu_id) {
            $documento = Documento::find($request->docu_id);
            $documento_aux = $documento;
            $documento_aux->update($request->except('docu_plantilla'));
        } else {
            $documento = Documento::create($request->except('docu_plantilla'));
        }
        if ($documento) {
            if ($request->file('docu_plantilla')) {
                $this->saveFile($request, $documento);
            }
        }
        return redirect()->back()->with('success', 'Elemento creado exitosamente.');
    }

    public function update(DocumentoRequest $request, Documento $documento)
    {
        $data = $request->all();
        $documento->update($data);
        return redirect()->back()->with('success', 'Elemento actualizado exitosamente.');
    }

    public function destroy(Documento $documento)
    {
        if ($documento->docu_plantilla) {
            Storage::disk('template')->delete($documento->docu_plantilla);
        }
        $documento->delete();
        return redirect()->back()->with('success', 'Elemento eliminado exitosamente. ' . $documento->docu_plantilla);
    }

    public function saveFile($request, Documento $documento)
    {
        $file_name = 'template' . '-' . time() . '.' . $request->docu_plantilla->extension();
        Storage::disk('template')->put($file_name, file_get_contents($request->docu_plantilla));

        if ($documento->docu_plantilla) {
            Storage::disk('template')->delete($documento->docu_plantilla);
        }
        
        $documento->docu_plantilla =  $file_name;
        $documento->save();
    }
}
