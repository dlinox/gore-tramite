<?php

namespace App\Http\Controllers;

use App\Http\Requests\PersonaRequest;
use App\Models\Persona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PersonaController extends Controller
{



    public function store(PersonaRequest $request)
    {
        $data = $request->all();
        $persona = Persona::create($data);
        return redirect()->back()->with(['success' => 'Elemento creado exitosamente.', 'data' => $persona]);
    }

    public function update(PersonaRequest $request, Persona $persona)
    {
        $data = $request->all();
        $persona->update($data);

        return redirect()->back()->with(['success' => 'Elemento actualizado exitosamente.', 'data' => $persona]);
        //return redirect()->back()->with('success', 'Elemento actualizado exitosamente.');
    }

    public function destroy(Persona $persona)
    {
        $persona->delete();
        return redirect()->back()->with('success', 'Elemento eliminado exitosamente.');
    }

    public function autocomplete(Request $request)
    {
        $results = [];
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $results = Persona::select('pers_id', 'pers_nombre', 'pers_paterno', 'pers_materno', 'pers_dni', 'pers_ruc', 'pers_celular', 'pers_correo')
                ->where('pers_nombre', 'like', '%' . $searchTerm . '%')
                ->orwhere('pers_paterno', 'like', '%' . $searchTerm . '%')
                ->orwhere('pers_materno', 'like', '%' . $searchTerm . '%')
                ->orwhere('pers_dni', 'like', '%' . $searchTerm . '%')
                ->orwhere('pers_ruc', 'like', '%' . $searchTerm . '%')
                ->limit(30)
                ->get();
        }
        return response()->json($results);
    }
}
