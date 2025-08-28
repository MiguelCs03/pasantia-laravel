<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\OrdenController;
use App\Http\Controllers\ProductoController;

// Rutas públicas
Route::apiResource('clientes', ClienteController::class);
Route::apiResource('ordenes', OrdenController::class);
Route::apiResource('productos', ProductoController::class);

// Ruta adicional para obtener productos activos (para formularios)
Route::get('productos-activos', [ProductoController::class, 'productosActivos']);

Route::group(['prefix' => 'auth'], function () {
    

});
