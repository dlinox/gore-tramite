<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AuthController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Auth/index');
    }

    public function signIn(Request $request)
    {
        $this->validate($request, [
            'email'   => 'required',
            'password' => 'required'
        ]);

        if (Auth::guard('admin')->attempt($request->all())) {
            $request->session()->regenerate();
            return redirect()->intended('/a');
        }

        return back()->withErrors([
            'message' => 'Admin: Credenciales incorrectas.',
            'status' => false
        ]);
    }

    public function signOut(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        return redirect('/a/login');
    }
}
