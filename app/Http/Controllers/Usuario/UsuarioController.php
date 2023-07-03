<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UsuarioController extends Controller
{
    //

    public function consultar()
    {
        return Inertia::render('Usuario/consultar');
    }
    public function consultarExpe()
    {
        return redirect()->back()->withErrors(['error' => 'Se ha producido un error inesperado. Si el problema persiste, te recomendamos que te pongas en contacto con el administrador para obtener ayuda adicional.', 'details' => 'Datos no encontrados']);

    }
}
