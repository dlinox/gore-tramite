<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\Auth\AuthController as AdminAuthController;
use App\Http\Controllers\Usuario\Auth\AuthController;
use Inertia\Inertia;

Route::get('/', [Controller::class,  'landingPage'])->name('landing');


Route::name('admin.')->prefix('a')->group(function () {

  Route::get('/login', [AdminAuthController::class, 'index'])->name('login');
  Route::post('/sign-in',  [AdminAuthController::class, 'signIn'])->name('sign-in');
  Route::delete('/sign-out',  [AdminAuthController::class, 'signOut'])->name('sign-out');

  Route::middleware('auth:admin')->get('/',  function () {
    return Inertia::render('Admin/index');
  })->name('index'); //dashboard usuario

});


Route::name('users.')->prefix('')->group(function () {
  Route::get('/login', [AuthController::class, 'index'])->name('login');
  Route::post('/sign-in',  [AuthController::class, 'signIn'])->name('sign-in');
  Route::delete('/sign-out',  [AuthController::class, 'signOut'])->name('sign-out');


  Route::middleware('auth')->get('virtual',  function () {
    return Inertia::render('Usuario/index');
  })->name('index'); //dashboard usuario
});
