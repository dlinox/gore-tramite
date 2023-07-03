<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class ConsultaController extends Controller
{
    public function index(){

        return Inertia::render('Admin/Consulta/index');
    }

}
