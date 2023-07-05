<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdministradorRequest;
use App\Models\Admin;
use App\Models\Oficina;
use App\Models\Rol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class AdminController extends Controller
{
    public function index(Request $request)
    {

        $data = Admin::getAdmins($request);
        return Inertia::render('Admin/Seguridad/Administrador/index', [
            ...$data,
            'oficinas' => Oficina::all(),
            'roles' => Rol::all()
        ]);
    }


    public function store(AdministradorRequest $request)
    {

        try {
            DB::transaction(function () use ($request) {

                $data = $request->all();
                $data['password'] = 'password';
                $admin =  Admin::create($data);
                $admin->assignRole($request->rol_name);
                $admin->ofic_name = Oficina::find($request->ofic_id)->ofic_nombre;
                $admin->save();
                return redirect()->back()->with(['success' => 'Elemento creado exitosamente.', 'data' => $admin]);
            });
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors(['error' => 'Se ha producido un error inesperado. Si el problema persiste, te recomendamos que te pongas en contacto con el administrador para obtener ayuda adicional.', 'details' => $th->getMessage()]);
        }
    }

    public function update(AdministradorRequest $request, Admin $administradore)
    {

        try {
            DB::transaction(function () use ($request, $administradore) {
                $data = $request->all();

                $temp1 = $request->ofic_id;
                $temp2 =  $administradore->ofic_id;

                if ($administradore->rol_name != $request->rol_name) {
                    $administradore->syncRoles([]);
                    $administradore->assignRole($request->rol_name);
                }
                $administradore->update($data);

                if ($temp1 != $temp2) {
                    $administradore->ofic_name = Oficina::find($request->ofic_id)->ofic_nombre;
                    $administradore->save();
                }

                return redirect()->back()->with('success',  $request->rol_name . ' - ' . $administradore->rol_name);
            });
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors(['error' => 'Se ha producido un error inesperado. Si el problema persiste, te recomendamos que te pongas en contacto con el administrador para obtener ayuda adicional.', 'details' => $th->getMessage()]);
        }
    }

    public function destroy(Admin $administradore)
    {

        $administradore->active = !$administradore->active;
        $administradore->save();
        return redirect()->back()->with('success', 'Estado actualizado con exito.');
    }
}
