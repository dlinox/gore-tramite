<?php

namespace App\Http\Controllers\Usuario\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AuthController extends Controller
{
    public function index()
    {
        return Inertia::render('Usuario/Auth/index');
    }

    public function signIn(Request $request)
    {
        $this->validate($request, [
            'document'   => 'required',
            'password' => 'required'
        ]);

        if (Auth::attempt($request->all())) {
            $request->session()->regenerate();
            return redirect()->intended('/virtual');
        }

        return back()->withErrors([
            'message' => 'Credenciales incorrectas..',
            'status' => false
        ]);
    }

    public function signOut(Request $request)
    {
        Auth::guard()->logout();
        $request->session()->invalidate();
        return redirect('/login');
    }
}
