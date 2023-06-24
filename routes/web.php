<?php

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::get('/', [Controller::class,  'landingPage']);


Route::name('admin.')->prefix('a')->group(function () {

});


Route::name('client.')->prefix('')->group(function () {
    
});