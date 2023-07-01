<?php

use App\Http\Controllers\AccionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\Auth\AuthController as AdminAuthController;
use App\Http\Controllers\DocumentoController;
use App\Http\Controllers\ExpedienteController;
use App\Http\Controllers\OficinaController;
use App\Http\Controllers\ProcesoController;
use App\Http\Controllers\ProcesoRequisitoController;
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

  Route::resource('oficinas', OficinaController::class);
  Route::resource('acciones', AccionController::class);

  Route::resource('documentos', DocumentoController::class);
  Route::resource('procesos', ProcesoController::class);
  Route::resource('proceso-requisitos', ProcesoRequisitoController::class);


  Route::middleware('auth:admin')->name('expedientes.')->prefix('expedientes')->group(function () {
    Route::get('', [ExpedienteController::class, 'index'])->name('index');
    Route::get('{tipo}/crear', [ExpedienteController::class, 'create'])->name('create');


    Route::post('', [ExpedienteController::class, 'store'])->name('store');


    Route::name('interno.')->prefix('interno')->group(function () {
      Route::get('', [ExpedienteController::class, 'interno']);
      // Route::get('crear', [ExpedienteController::class, 'internoCreate'])->name('store');
      Route::post('guardar/{expediente?}', [ExpedienteController::class, 'internoStore'])->name('store');
      Route::post('editar/{expediente}', [ExpedienteController::class, 'internoEdit'])->name('edit');
      Route::post('ver/{expediente}', [ExpedienteController::class, 'showEdit'])->name('show');
    });

    Route::name('emitidos.')->prefix('emitidos')->group(function () {
      Route::get('', [ExpedienteController::class, 'indexEmitidos'])->name('index');
      // Route::get('crear', [ExpedienteController::class, 'internoCreate'])->name('store');
      //Route::post('guardar/{expediente?}', [ExpedienteController::class, 'internoStore'])->name('store');
      // Route::post('editar/{expediente}', [ExpedienteController::class, 'internoEdit'])->name('edit');
      // Route::post('ver/{expediente}', [ExpedienteController::class, 'showEdit'])->name('show');
    });


    Route::get('interno', [ExpedienteController::class, 'internoCreate'])->name('interno.create');

    Route::get('externo', [ExpedienteController::class, 'externo'])->name('externo');

    Route::get('get-next-num-documento', [ExpedienteController::class, 'getNextNumDocumento'])->name('get-next-num-documento');
    Route::get('get-admins-by-ofic/{oficina}', [ExpedienteController::class, 'getAdminsByOfic'])->name('get-admins-by-ofic');
  });
});


Route::name('users.')->prefix('')->group(function () {
  Route::get('/login', [AuthController::class, 'index'])->name('login');
  Route::post('/sign-in',  [AuthController::class, 'signIn'])->name('sign-in');
  Route::delete('/sign-out',  [AuthController::class, 'signOut'])->name('sign-out');


  Route::middleware('auth')->get('virtual',  function () {
    return Inertia::render('Usuario/index');
  })->name('index'); //dashboard usuario
});
