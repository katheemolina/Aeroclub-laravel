<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ConfiguracionesContoller extends Controller
{

    public function obtenerConfiguraciones()
    {
        try {
            // Ejecutar el procedimiento almacenado ObtenerTarifas
            $tarifas = DB::select('CALL ObtenerConfiguraciones()');

            // Retornar los resultados como respuesta JSON
            return response()->json([
                'status' => 'success',
                'data' => $tarifas
            ]);
        } catch (\Exception $e) {
            // Si ocurre algún error, retornar un mensaje de error
            return response()->json([
                'status' => 'error',
                'message' => 'Hubo un error al obtener las config',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function actualizarConfiguraciones(Request $request)
    {
        // Validar los datos recibidos
        $validatedData = $request->validate([
            'tiempo_adaptacion' => 'required|integer|min:1',
            'aterrizajes_adaptacion' => 'required|integer|min:1',
            'dias_vencimiento_cma' => 'required|integer|min:1',
            'saldo_inicial' => 'required|numeric|min:0',
            'numero_recibo_inicial' => 'required|integer|min:1',
        ]);

        // Llamada al procedimiento almacenado para actualizar configuraciones
        DB::statement('CALL ActualizarConfiguraciones(?, ?, ?, ?, ?)', [
            $validatedData['tiempo_adaptacion'],
            $validatedData['aterrizajes_adaptacion'],
            $validatedData['dias_vencimiento_cma'],
            $validatedData['saldo_inicial'],
            $validatedData['numero_recibo_inicial']
        ]);

        // Retornar una respuesta de éxito
        return response()->json(['message' => 'Configuraciones actualizadas correctamente.'], 200);
    }
}