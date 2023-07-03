<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RolController extends Controller
{
    //

    public function index(){
        return Inertia::render('Admin/Seguridad/Rol/index');
    }
}
