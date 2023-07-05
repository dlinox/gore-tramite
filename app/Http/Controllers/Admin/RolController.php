<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RolRequest;
use App\Models\Rol;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RolController extends Controller
{
    //

    public function index(Request $request)
    {

        $data = Rol::getRoles($request);
        return Inertia::render('Admin/Seguridad/Rol/index', $data);
    }


    public function store(RolRequest $request)
    {
        $data = $request->all();
        $data['guard_name'] = 'admin';
        $item =  Rol::create($data);
        return redirect()->back()->with(['success' => 'Elemento creado exitosamente.', 'data' => $item]);
    }

    public function update(RolRequest $request, Rol $role)
    {
        $data = $request->all();
        $role->update($data);
        return redirect()->back()->with('success', 'Elemento actualizado exitosamente.');
    }

    public function destroy(Rol $role)
    {

        $role->delete();
        return redirect()->back()->with('success', 'Elemento eliminado exitosamente.');
    }
}
