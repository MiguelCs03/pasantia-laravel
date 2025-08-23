<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\OrdenController;

// Rutas públicas
Route::apiResource('clientes', ClienteController::class);
Route::apiResource('ordenes', OrdenController::class);

Route::group(['prefix' => 'auth'], function () {
    

});
