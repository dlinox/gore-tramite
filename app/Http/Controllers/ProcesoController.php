<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProcesoRequest;
use App\Models\Documento;
use App\Models\Proceso;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProcesoController extends Controller
{
    protected $proceso;
    public function __construct()
    {
        $this->proceso = new Proceso();
    }

    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);
        $query = Proceso::query();

        // Búsqueda por el campo de busqueda
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where('proc_nombre', 'like', '%' . $searchTerm . '%');
        }

        // Obtener resultados paginados
        $items = $query->paginate($perPage)->appends($request->query());

        return Inertia::render('Admin/Proceso/index', [
            'items' => $items,
            'itemsDocuments' => Documento::all(),
            'headers' => $this->proceso->headers,
            'filters' => [
                'search' => $request->search,
                //mas filtros
            ],
        ]);
    }

    public function store(ProcesoRequest $request)
    {
        $data = $request->all();
        $proceso =  Proceso::create($data);
        return redirect()->back()->with(['success' => 'Elemento creado exitosamente.', 'data' => $proceso]);
    }

    public function update(ProcesoRequest $request, Proceso $proceso)
    {
        $data = $request->all();
        $proceso->update($data);
        return redirect()->back()->with('success', 'Elemento actualizado exitosamente.');
    }

    public function destroy(Proceso $proceso)
    {
        $proceso->delete();
        return redirect()->back()->with('success', 'Elemento eliminado exitosamente.');
    }
}
