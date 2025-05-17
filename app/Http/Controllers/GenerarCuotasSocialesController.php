<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Psy\Readline\Hoa\Console;

class GenerarCuotasSocialesController extends Controller
{
    public function generarCuotasSociales(Request $request)
    {
        try {
            // Validar los parámetros que esperamos recibir
            $validated = $request->validate([
                'mes' => 'required|string',
                'anio' => 'required|string',
                'importe' => 'required|numeric',
                'id_usuario_evento' => 'required|integer',
            ]);

            // Llamar al procedimiento almacenado sp_generar_cuotas_sociales con los parámetros recibidos
            $result = DB::select('CALL GenerarCuotasSociales(?, ?, ?, ?)', [
                $validated['mes'], 
                $validated['anio'], 
                $validated['importe'], 
                $validated['id_usuario_evento']
            ]);
    

            // Devolver respuesta exitosa con el resultado
            return response()->json([
                'message' => 'Cuotas sociales generadas con éxito.',
                'data' => $result
            ], 200);

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Manejo de errores de validación
            return response()->json([
                'error' => 'Datos de entrada inválidos', 
                'message' => $e->errors()
            ], 422);
        } catch (\PDOException $e) {
            // Manejo de errores de base de datos (como el error lanzado por SIGNAL)
            if (strpos($e->getMessage(), 'Ya existen cuotas sociales para este mes') !== false) {
                return response()->json([
                    'error' => 'Conflicto de datos', 
                    'message' => 'Ya existen cuotas sociales para este mes'
                ], 409); // HTTP Status Code 409: Conflict
            }
            
            // Si el error no es por la cuota social duplicada, devuelve el error de la base de datos
            return response()->json([
                'error' => 'Error en la base de datos', 
                'message' => $e->getMessage()
            ], 500);
        } catch (\Exception $e) {
            // Manejo de errores generales
            return response()->json([
                'error' => 'Error interno', 
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
