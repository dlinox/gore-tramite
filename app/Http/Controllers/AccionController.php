<?php

namespace App\Http\Controllers;

use App\Http\Requests\AccionRequest;
use App\Models\Accion;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AccionController extends Controller
{
    protected $accion;
    public function __construct()
    {
        $this->accion = new Accion();
    }

    public function index(Request $request)
    {

        $perPage = $request->input('perPage', 10);
        $query = Accion::query();

        // Búsqueda por el campo de busqueda
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where('acci_nombre', 'like', '%' . $searchTerm . '%');
        }

        // Obtener resultados paginados
        $items = $query->paginate($perPage)->appends($request->query());

        return Inertia::render('Admin/Accion/index', [
            'items' => $items,
            'headers' => $this->accion->headers,
            'filters' => [
                'search' => $request->search,
                //mas filtros
            ],
        ]);
    }

    public function store(AccionRequest $request)
    {
        $data = $request->all();
        Accion::create($data);
        return redirect()->back()->with('success', 'Elemento creado exitosamente.');
    }

    public function update(AccionRequest $request, Accion $accione)
    {
        $data = $request->all();
        $accione->update($data);
        return redirect()->back()->with('success', 'Elemento actualizado exitosamente.');
    }

    public function destroy(Accion $accione)
    {
        $accione->delete();
        return redirect()->back()->with('success', 'Elemento eliminado exitosamente.');
    }
}
