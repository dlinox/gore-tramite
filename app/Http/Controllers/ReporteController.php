<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class ReporteController extends Controller
{
    public function index(){

        return Inertia::render('Admin/Reporte/index');
    }
}
