<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovimientosController;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\VuelosController;
use App\Http\Controllers\RecibosController;


//RUTAS PARA ASOCIADOS
//dashboard
Route::get('/usuarios/{idUsuario}', [UsuariosController::class, 'obtenerDatosDelUsuario']); //trae toda la informacion del usuario
Route::get('/movimientos/{idUsuario}/saldo', [MovimientosController::class, 'saldoCuentaCorrientePorUsuario']); //trae saldo actual del asociado, suma los campos de movimientos
Route::get('/usuarios/{idUsuario}/cma', [UsuariosController::class, 'obtenerEstadoCMA']); //devuelve el estado del cma
Route::get('/vuelos/{idUsuario}/horasVoladas', [VuelosController::class, 'horasVoladasPorUsuario']); //Devuelve la sumatoria de las horas voladas
Route::get('/vuelos/{idUsuario}/ultimosVuelos', [VuelosController::class, 'ultimosVuelosPorUsuario']); //agrupa por aeronave para evaluar si esta adaptado
Route::get('/usuarios/{idUsuario}/licencias', [UsuariosController::class, 'obtenerLicenciasPorUsuario']); //devuelve listado de las licencias que tiene el usuario


//perfil
//vuelve a utilizar la ruta Route::get('/usuarios/{id}', [UsuariosController::class, 'obtenerDatosDelUsuario']);

Route::put('/usuarios/{id}', [UsuariosController::class, 'actualizarDatosDelUsuario']); //Actualiza datos del usuario


//libro de vuelo
Route::get('/vuelos/{id_usuario}/libroVuelo', [VuelosController::class, 'obtenerLibroDeVueloPorUsuario']);//obtiene el listado del libro de vuelo por usuario

//cuenta corriente
Route::get('/movimientos/{id_usuario}', [MovimientosController::class, 'cuentaCorrientePorUsuario']); //trae un listado de movimientos del usuario lo usamos en la ventana cuenta corriente

//RUTAS PARA GESTOR
//REVISAR ------ Route::get('/movimientos', [MovimientosController::class, 'obtenerTodosLosMovimientos']); //trae un listado total de movimientos
Route::get('/movimientos/{id}/noPago', [MovimientosController::class, 'obtenerMovimientosNoPagos']);

//Todos los itinerarios para ver los vuelos
Route::get('/itinerarios', [VuelosController::class, 'obtenerTodosLosItinerarios']);

Route::get('/recibos', [RecibosController::class, 'obtenerTodosLosRecibos']);


//Rutas para instructor
Route::get('/asociados', [UsuariosController::class, 'listarAsociados']); //de

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


