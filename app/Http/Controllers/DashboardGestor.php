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

    public function contadoresDeCuentas()
    {
        // Llama al procedimiento almacenado
        $result = DB::select('CALL ContadoresDeCuentas()');

        // Verifica si el resultado está vacío
        if (empty($result)) {
            return response()->json(['message' => 'No se encontraron datos.'], 404);
        }

        // Retorna el resultado como JSON
        return response()->json($result);
    }

    public function obtenerUltimasCuentas()
    {
        // Llama al procedimiento almacenado
        $result = DB::select('CALL Ultimas10Cuentas()');

        // Verifica si el resultado está vacío
        if (empty($result)) {
            return response()->json(['message' => 'No se encontraron cuentas recientes.'], 404);
        }

        // Retorna el resultado como JSON
        return response()->json($result);
    }

    public function obtenerTopDeudores()
    {
        // Llama al procedimiento almacenado
        $result = DB::select('CALL Top10Deudores()');

        // Verifica si el resultado está vacío
        if (empty($result)) {
            return response()->json(['message' => 'No se encontraron deudores.'], 404);
        }

        // Retorna el resultado como JSON
        return response()->json($result);
    }

    public function obtenerHorasPorDiaAeronaves()
{
    try {
        // Llama al procedimiento almacenado
        $result = DB::select('CALL GraficoHorasPorDiasAeronaves()');

        // Verifica si el resultado está vacío
        if (empty($result)) {
            return response()->json(['message' => 'No se encontraron datos para el gráfico.'], 404);
        }

        // Retorna el resultado como JSON
        return response()->json($result);
    } catch (\Exception $e) {
        // Manejo de errores
        return response()->json(['message' => 'Error al obtener los datos', 'error' => $e->getMessage()], 500);
    }
}




}