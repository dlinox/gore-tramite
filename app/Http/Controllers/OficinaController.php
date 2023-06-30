<?php

namespace App\Http\Controllers;

use App\Http\Requests\OficinaRequest;
use App\Models\Oficina;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OficinaController extends Controller
{
    protected $oficina;
    public function __construct()
    {
        $this->oficina = new Oficina();
    }

    public function index(Request $request)
    {

        $perPage = $request->input('perPage', 10);
        $query = Oficina::query();

        // Búsqueda por el campo de busqueda
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where('ofic_nombre', 'like', '%' . $searchTerm . '%');
        }

        // Obtener resultados paginados
        $items = $query->paginate($perPage)->appends($request->query());

        return Inertia::render('Admin/Oficina/index', [
            'items' => $items,
            'headers' => $this->oficina->headers,
            'filters' => [
                'search' => $request->search,
                //mas filtros
            ],
        ]);
    }

    public function store(OficinaRequest $request)
    {
        $data = $request->all();
        Oficina::create($data);
        return redirect()->back()->with('success', 'Elemento creado exitosamente.');
    }

    public function update(OficinaRequest $request, Oficina $oficina)
    {
        $data = $request->all();
        $oficina->update($data);
        return redirect()->back()->with('success', 'Elemento actualizado exitosamente.');
    }

    public function destroy(Oficina $oficina)
    {
        $oficina->delete();
        return redirect()->back()->with('success', 'Elemento eliminado exitosamente.');
    }
}
