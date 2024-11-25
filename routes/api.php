<?php

use App\Http\Controllers\DashboardGestor;
use App\Http\Controllers\GenerarCuotasSocialesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovimientosController;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\VuelosController;
use App\Http\Controllers\RecibosController;

use App\Http\Controllers\TarifasController;
use App\Http\Controllers\AeronavesController;

use App\Http\Controllers\IngresoController;

use App\Http\Controllers\GenerarReciboController;

use App\Http\Controllers\ServiciosAeronavesController;

Route::get('aeronaves', [AeronavesController::class, 'obtenerAeronaves']); // Para obtener aeronaves
Route::post('aeronaves', [AeronavesController::class, 'insertarAeronave']); // Para insertar aeronave
//Route::put('aeronaves/{id}', [AeronavesController::class, 'actualizarAeronave']); // Actualizar aeronave

Route::get('tarifasCombustible', [TarifasController::class, 'obtenerTarifasCombustible']); // Para obtener las tarifas
Route::get('tarifas', [TarifasController::class, 'obtenerTarifas']); // Para obtener las tarifas
Route::post('tarifas', [TarifasController::class, 'insertarTarifa']); // Para insertar una nueva tarifa
Route::put('tarifas/{id}', [TarifasController::class, 'actualizarTarifa']); 


Route::put('/actualizar-usuario/{id}', [UsuariosController::class, 'actualizarDatosDelUsuario']);
Route::put('/usuarios/{id}/licencias', [UsuariosController::class, 'actualizarLicencias']);


//RUTAS PARA ASOCIADOS
//dashboard
Route::get('/usuarios/{idUsuario}', [UsuariosController::class, 'obtenerDatosDelUsuario']); //trae toda la informacion del usuario
Route::get('/movimientos/{idUsuario}/saldo', [MovimientosController::class, 'saldoCuentaCorrientePorUsuario']); //trae saldo actual del asociado, suma los campos de movimientos
Route::get('/usuarios/{idUsuario}/cma', [UsuariosController::class, 'obtenerEstadoCMA']); //devuelve el estado del cma
Route::get('/vuelos/{idUsuario}/horasVoladas', [VuelosController::class, 'horasVoladasPorUsuario']); //Devuelve la sumatoria de las horas voladas
Route::get('/vuelos/{idUsuario}/ultimosVuelos', [VuelosController::class, 'ultimosVuelosPorUsuario']); //agrupa por aeronave para evaluar si esta adaptado
Route::get('/usuarios/{idUsuario}/licencias', [UsuariosController::class, 'obtenerLicenciasPorUsuario']); //devuelve listado de las licencias que tiene el usuario
Route::get('/roles/{idUsuario}', [UsuariosController::class, 'obtenerRolesPorUsuario']); //trae los roles del usuario

//perfil
//vuelve a utilizar la ruta Route::get('/usuarios/{id}', [UsuariosController::class, 'obtenerDatosDelUsuario']);

Route::put('/usuarios/{id}', [UsuariosController::class, 'actualizarDatosDelUsuario']); //Actualiza datos del usuario


//libro de vuelo
Route::get('/vuelos/{id_usuario}/libroVuelo', [VuelosController::class, 'obtenerLibroDeVueloPorUsuario']);//obtiene el listado del libro de vuelo por usuario

//cuenta corriente
Route::get('/cuentaCorriente/{id_usuario}', [MovimientosController::class, 'cuentaCorrientePorUsuario']); //trae un listado de movimientos del usuario lo usamos en la ventana cuenta corriente

//RUTAS PARA GESTOR
Route::get('/movimientos', [MovimientosController::class, 'obtenerTodosLosMovimientos']); //trae un listado total de movimientos
Route::get('/movimientos/{id}/noPago', [MovimientosController::class, 'obtenerMovimientosNoPagos']);
Route::get('/movimientosAeroclub', [MovimientosController::class, 'obtenerCuentaCorrienteAeroclub']); //trae un listado total de movimientos
Route::get('/movimientosAeroclubDetalle/{referencia}', [MovimientosController::class, 'obtenerCuentaCorrienteAeroclubDetalle']); //trae un listado total de movimientos

Route::get('/saldoAeroclub', [DashboardGestor::class, 'saldoCuentaCorrienteAeroclub']); //trae un listado total de movimientos
Route::get('/horasUltimoMes', [DashboardGestor::class, 'horasVueloUltimoMes']); //trae un listado total de movimientos


//Todos los itinerarios para ver los vuelos
Route::get('/itinerarios', [VuelosController::class, 'obtenerTodosLosItinerarios']);

Route::get('/recibos', [RecibosController::class, 'obtenerTodosLosRecibos']);


//Rutas para instructor
Route::get('/asociados', [UsuariosController::class, 'listarAsociados']); //
Route::get('/movimientosNoLiquidadosPorInstructor', [UsuariosController::class, 'MovimientosNoLiquidadosPorInstructor']); //
Route::post('/armarLiquidacion', [GenerarReciboController::class, 'armarLiquidacion']);
Route::put('/modificarEstado/{usuarioId}', [UsuariosController::class, 'modificarEstadoAsociado']); //

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::put('/verificarUsuario', [IngresoController::class, 'verificarOCrearUsuario']); 

Route::get('/obtenerTiposVuelos', [GenerarReciboController::class, 'obtenerTiposVuelos']);

Route::get('/obtenerInstructores', [GenerarReciboController::class, 'obtenerInstructores']);

Route::post('/generarRecibo', [GenerarReciboController::class, 'generarRecibo']);

Route::post('/pagarRecibo', [GenerarReciboController::class, 'pagarRecibos']);

Route::get('/obtenerUsuario/{email}', [IngresoController::class, 'obtenerIdUsuarioDesdeMail']); 

Route::post('/usuario/habilitar', [UsuariosController::class, 'habilitarUsuario']);

Route::post('/usuario/deshabilitar', [UsuariosController::class, 'deshabilitarUsuario']);

Route::post('/usuario/actualizarRoles', [UsuariosController::class, 'actualizarRoles']);

Route::post('/usuario/eliminarRol', [UsuariosController::class, 'eliminarRol']);

Route::post('/tarifa/eliminar', [TarifasController::class, 'eliminarTarifa']);

Route::post('/aeronave/eliminar', [AeronavesController::class, 'eliminarAeronave']);

Route::post('/generarCuotasSociales', [GenerarCuotasSocialesController::class, 'generarCuotasSociales']);

Route::get('/obtenerEstadoUsuario/{id}', [IngresoController::class, 'obtenerEstadoDelUsuario']); 

Route::put('/aeronaves/{id_aeronave}/cambiarEstado', [AeronavesController::class, 'cambiarEstado']);

Route::put('/aeronaves/cambioPoliza', [AeronavesController::class, 'cambiarDatosPoliza']);

Route::put('/aeronaves/actualizarIntervaloInspeccion', [AeronavesController::class, 'actualizarIntervaloInspeccion']);


Route::put('/serviciosAeronaves/{id_aeronave}', [ServiciosAeronavesController::class, 'actualizarServicio']);

Route::get('/serviciosAeronaves/{id_aeronave}', [ServiciosAeronavesController::class, 'obtenerServicios']);

Route::post('/serviciosAeronaves', [ServiciosAeronavesController::class, 'insertarServicio']);


