<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GenerarReciboController extends Controller{

    //En este controller van a estar todos los endpoint que necesitamos para crear los recibos

    public function obtenerTiposVuelos()
{
    try {
        // Ejecutar el procedimiento almacenado
        $tiposVuelos = DB::select('CALL ObtenerTiposVuelos()');

        // Devolver los resultados como JSON
        return response()->json(['data' => $tiposVuelos], 200);
    } catch (\Exception $e) {
        // Capturar errores y devolver un mensaje de error
        return response()->json(['error' => $e->getMessage()], 500);
    }
}


public function obtenerInstructores()
{
    try {
        // Ejecutar el procedimiento almacenado
        $instructores = DB::select('CALL ListarInstructores()');

        // Devolver los resultados como JSON
        return response()->json(['data' => $instructores], 200);
    } catch (\Exception $e) {
        // Capturar errores y devolver un mensaje de error
        return response()->json(['error' => $e->getMessage()], 500);
    }
}


}