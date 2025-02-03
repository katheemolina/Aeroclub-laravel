<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RecibosController extends Controller{

    public function obtenerTodosLosRecibos(Request $request)
    {
    $idUsuario = $request->input('id', 0); // Toma el ID del usuario desde los parámetros de la solicitud, o 0 si no se proporciona
    $fechaDesde = $request->input('fecha_desde'); // Toma la fecha desde desde los parámetros de la solicitud
    $fechaHasta = $request->input('fecha_hasta'); // Toma la fecha hasta desde los parámetros de la solicitud

    $fechaDesde = $fechaDesde ? date('Y-m-d', strtotime($fechaDesde)) : null;
    $fechaHasta = $fechaHasta ? date('Y-m-d', strtotime($fechaHasta)) : null;
    
    // Llamada al procedimiento almacenado
    $result = DB::select('CALL TodosLosRecibos(?, ?, ?)', [$idUsuario, $fechaDesde, $fechaHasta]);

    // Verificar si el resultado está vacío
    if (empty($result)) {
        return response()->json(['message' => 'No se encontraron recibos.'], 404);
    }

    // Retornar el resultado en formato JSON
    return response()->json($result);
}


public function anularRecibo(Request $request)
{
    // Validar la entrada
    $request->validate([
        'numero_recibo' => 'required|integer'
    ]);

    try {
        // Llamada al procedimiento almacenado
        $result = DB::select('CALL AnularRecibo(?)', [$request->numero_recibo]);

        return response()->json([
            'status' => 'success',
            'message' => 'El recibo ha sido anulado correctamente.',
            'data' => $result
        ], 200);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Error al anular el recibo: ' . $e->getMessage()
        ], 500);
    }
}

}


