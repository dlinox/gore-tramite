<?php

namespace App\Http\Controllers;

use App\Models\ProcesoRequisito;
use Illuminate\Http\Request;

class ProcesoRequisitoController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->all();
        ProcesoRequisito::create($data);
        return redirect()->back()->with('success', 'Elemento creado exitosamente.');
    }

    public function destroy(ProcesoRequisito $proceso_requisito)
    {
        $proceso_requisito->delete();
        return redirect()->back()->with('success', 'Elemento eliminado exitosamente. ');
    }
}
