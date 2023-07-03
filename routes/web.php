<?php

use App\Http\Controllers\AccionController;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\Auth\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\RolController;
use App\Http\Controllers\ConsultaController;
use App\Http\Controllers\DocumentoController;
use App\Http\Controllers\ExpedienteController;
use App\Http\Controllers\MensajeController;
use App\Http\Controllers\OficinaController;
use App\Http\Controllers\PersonaController;
use App\Http\Controllers\ProcesoController;
use App\Http\Controllers\ProcesoRequisitoController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\Usuario\Auth\AuthController;
use App\Http\Controllers\Usuario\UsuarioController;
use Inertia\Inertia;

Route::get('/', [Controller::class,  'landingPage'])->name('landing');

Route::middleware('auth:admin')->name('admin.')->prefix('a')->group(function () {

    Route::get('/login', [AdminAuthController::class, 'index'])->name('login');
    Route::post('/sign-in',  [AdminAuthController::class, 'signIn'])->name('sign-in');
    Route::delete('/sign-out',  [AdminAuthController::class, 'signOut'])->name('sign-out');

    Route::get('/',  function () {
        return Inertia::render('Admin/index');
    })->name('index'); //dashboard usuario

    Route::resource('personas', PersonaController::class);

    Route::resource('oficinas', OficinaController::class);
    Route::resource('acciones', AccionController::class);

    Route::resource('documentos', DocumentoController::class);
    Route::resource('procesos', ProcesoController::class);
    Route::resource('proceso-requisitos', ProcesoRequisitoController::class);



    Route::name('consultas.')->prefix('consultas')->group(function () {
        Route::get('', [ConsultaController::class, 'index'])->name('index');
    });

    Route::name('reportes.')->prefix('reportes')->group(function () {
        Route::get('', [ReporteController::class, 'index'])->name('index');
    });

    Route::name('mensajes.')->prefix('mensajes')->group(function () {
        Route::get('', [MensajeController::class, 'index'])->name('index');
    });



    Route::name('expedientes.')->prefix('expedientes')->group(function () {
        Route::get('', [ExpedienteController::class, 'index'])->name('index');

        Route::get('internos', [ExpedienteController::class, 'internos'])->name('internos');
        Route::get('externos', [ExpedienteController::class, 'externos'])->name('externos');
        Route::get('archivados', [ExpedienteController::class, 'archivados'])->name('archivados');
        Route::get('derivados', [ExpedienteController::class, 'derivados'])->name('derivados');
        Route::get('finalizados', [ExpedienteController::class, 'finalizados'])->name('finalizados');
        Route::get('observados', [ExpedienteController::class, 'observados'])->name('observados');



        Route::get('{tipo}/crear', [ExpedienteController::class, 'create'])->name('create');
        Route::get('/{tramite}/revisar', [ExpedienteController::class, 'show'])->name('show');

        Route::post('', [ExpedienteController::class, 'store'])->name('store');
        Route::post('recibir', [ExpedienteController::class, 'recibir'])->name('recibir');
        Route::post('observar', [ExpedienteController::class, 'observar'])->name('observar');
        Route::post('archivar', [ExpedienteController::class, 'archivar'])->name('archivar');
        Route::post('finalizar', [ExpedienteController::class, 'finalizar'])->name('finalizar');
        Route::post('derivar', [ExpedienteController::class, 'derivar'])->name('derivar');


        Route::get('get-next-num-documento', [ExpedienteController::class, 'getNextNumDocumento'])->name('get-next-num-documento');
        Route::get('get-admins-by-ofic/{oficina}', [ExpedienteController::class, 'getAdminsByOfic'])->name('get-admins-by-ofic');
    });

    Route::name('seguridad.')->prefix('seguridad')->group(function () {
        Route::resource('roles', RolController::class);
        Route::resource('administradores', AdminController::class);
    });
});


Route::name('users.')->prefix('')->group(function () {
    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::post('/sign-in',  [AuthController::class, 'signIn'])->name('sign-in');
    Route::delete('/sign-out',  [AuthController::class, 'signOut'])->name('sign-out');


    Route::get('/consultar', [UsuarioController::class, 'consultar'])->name('consultar');
    Route::post('/consultar', [UsuarioController::class, 'consultarExpe'])->name('consultar-expe');
    

    Route::middleware('auth')->get('virtual',  function () {
        return Inertia::render('Usuario/index');
    })->name('index'); //dashboard usuario
});


Route::name('autocomplete.')->prefix('autocomplete')->group(function () {
    Route::get('personas', [PersonaController::class, 'autocomplete'])->name('personas');
});
