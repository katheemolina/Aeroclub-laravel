<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardGestor extends Controller
{
    public function saldoCuentaCorrienteAeroclub()
    {
        // Llama al procedimiento almacenado
        $result = DB::select('CALL SaldoCuentaCorrienteAeroclub()');

        // Verifica si el resultado está vacío
        if (empty($result)) {
            return response()->json(['message' => 'No se encontraron movimientos.'], 404);
        }

        // Retorna el resultado como JSON
        return response()->json($result);
    }

    public function horasVueloUltimoMes()
    {
        try {
            // Llamar al procedimiento almacenado
            $result = DB::select('CALL HorasVueloUltimoMes()');

            // Verificar si el resultado está vacío
            if (empty($result)) {
                return response()->json(['message' => 'No se encontraron datos de horas de vuelo para el último mes.'], 404);
            }

            // Retornar los datos en formato JSON
            return response()->json($result);

        } catch (\Exception $e) {
            // Manejar errores
            return response()->json([
                'message' => 'Error al obtener las horas de vuelo.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}