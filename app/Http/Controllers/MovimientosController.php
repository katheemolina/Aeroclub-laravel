<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MovimientosController extends Controller
{
    /**
    * Calcula el saldo del usuario sumando todos los movimientos.
    *
    * @param  int  $id
    * @return \Illuminate\Http\JsonResponse
    */
    public function saldoCuentaCorrientePorUsuario($idUsuario)
    {
    // Pasar el parámetro dentro de la llamada al procedimiento
    $result = DB::select('CALL saldoCuentaCorrientePorUsuario(?)', [$idUsuario]);

    if (empty($result)) {
        return response()->json(['message' => 'No se encontraron movimientos.'], 404);
    }

    return response()->json($result);
    }

    /**
    * Devuelve todos los movimientos por usuario.
    *
    * @param  int  $id
    * @return \Illuminate\Http\JsonResponse
    */
    public function cuentaCorrientePorUsuario($idUsuario)
    {

        $result = DB::select('CALL CuentaCorrientePorUsuario(?)', [$idUsuario]);

        if (empty($result)) {
            return response()->json(['message' => 'No se encontraron movimientos.'], 404);
        }

        return response()->json($result);
    }

    /**
    * Obtiene todos los movimientos no pagos. 
    * 
    * 
    * @return \Illuminate\Http\JsonResponse
    */

    public function obtenerMovimientosNoPagos($id)
    {
        // Llamada al procedimiento almacenado
        $result = DB::select('CALL MovimientosNoPagosPorUsuario(?)', [$id]);

        // Verificar si el resultado está vacío
        if (empty($result)) {
            return response()->json(['message' => 'No se encontraron movimientos no pagos para el usuario.'], 404);
        }

        // Retornar el resultado en formato JSON
        return response()->json($result);
    }


 
    /**
    * Obtiene todos los movimientos. 
    * No le pasamos valores por parametro, utilizaremos esta funcion para el gestor
    * 
    * @return \Illuminate\Http\JsonResponse
    */
    public function obtenerTodosLosMovimientos($id = 0)
    {
    // Llamada al procedimiento almacenado
    $result = DB::select('CALL TodosLosMovimientos(?)', [$id]);

    // Verificar si el resultado está vacío
    if (empty($result)) {
        return response()->json(['message' => 'No se encontraron movimientos.'], 404);
    }

    // Retornar el resultado en formato JSON
    return response()->json($result);
    }

}
