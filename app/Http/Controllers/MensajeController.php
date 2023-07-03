<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class MensajeController extends Controller
{
    public function index(){

        return Inertia::render('Admin/Mensaje/index');
    }
}
