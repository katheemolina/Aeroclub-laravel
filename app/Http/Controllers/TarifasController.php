<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class TarifasController extends Controller
{

    public function obtenerTarifas()
    {
        try {
            // Ejecutar el procedimiento almacenado ObtenerTarifas
            $tarifas = DB::select('CALL ObtenerTarifas()');

            // Retornar los resultados como respuesta JSON
            return response()->json([
                'status' => 'success',
                'data' => $tarifas
            ]);
        } catch (\Exception $e) {
            // Si ocurre algún error, retornar un mensaje de error
            return response()->json([
                'status' => 'error',
                'message' => 'Hubo un error al obtener las tarifas',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function insertarTarifa(Request $request)
    {
        // Validar los datos recibidos
        $validated = $request->validate([
            'fecha_vigencia' => 'required|date',
            'tipo_tarifa' => 'required|string|max:100',
            'importe' => 'required|numeric',
            'importe_por_instruccion' => 'required|numeric',
        ]);

        try {
            // Ejecutar el procedimiento almacenado InsertarTarifas
            DB::select('CALL InsertarTarifas(?, ?, ?, ?)', [
                $validated['fecha_vigencia'],
                $validated['tipo_tarifa'],
                $validated['importe'],
                $validated['importe_por_instruccion']
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Tarifa insertada correctamente'
            ]);
        } catch (\Exception $e) {
            // En caso de error, retornar un mensaje de error
            return response()->json([
                'status' => 'error',
                'message' => 'Hubo un error al insertar la tarifa',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function actualizarTarifa(Request $request, $id)
    {
        // Validar los datos recibidos
        $validatedData = $request->validate([
          'fecha_vigencia' => 'required|date_format:Y-m-d',
        'tipo_tarifa' => 'required|string|max:100',
        'importe' => 'required|numeric',
        'importe_por_instruccion' => 'nullable|numeric'
        ]);

        // Llamada al procedimiento almacenado
        DB::statement('CALL ActualizarTarifas(?, ?, ?, ?, ?)', [
            $id,  // ID de la tarifa que se pasa como parámetro en la URL
            $validatedData['fecha_vigencia'],
            $validatedData['tipo_tarifa'],
            $validatedData['importe'],
            $validatedData['importe_por_instruccion'] ?? 0  // Valor predeterm
        ]);

        // Retornar una respuesta de éxito
        return response()->json(['message' => 'okkkkkkkkkkkkk.'], 200);
    }

}