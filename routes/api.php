<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovimientoController;
use App\Http\Controllers\CMAController;


//Rutas para asociados
Route::get('/movimientos/suma/{id_usuario}', [MovimientoController::class, 'sumaMovimientosPorUsuario']); //trae saldo actual del asociado, suma los campos de movimientos
Route::get('/usuarios/{id}/cma', [CMAController::class, 'obtenerEstadoCMA']); //devuelve el estado del cma


//Rutas para gestor


//Rutas para instructor


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


