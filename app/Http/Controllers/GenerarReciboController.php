<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Psy\Readline\Hoa\Console;

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

    public function generarRecibo(Request $request)
    {
        try {
            // Validar los parámetros que esperamos recibir
            $validated = $request->validate([
                'IdUsuario' => 'required|integer',
                'TipoRecibo' => 'required|string|max:150',
                'Cantidad' => 'required|numeric',
                'Importe' => 'required|numeric',
                'Fecha' => 'required|date',
                'Instruccion' => 'required|integer',
                'IdInstructor' => 'nullable|integer',  // El instructor es opcional
                'Itinerarios' => 'required|integer',  // Número de itinerarios
                'Datos' => 'required|json',  // Validar que sea un JSON válido
                'Observaciones' => 'nullable|string|max:255',
                'Aeronave' => 'required|integer',
                'Tarifa' => 'required|integer',
                'TipoItinerario' => 'required|integer'
            ]);

            // Extraer los datos validados
            $IdUsuario = $validated['IdUsuario'];
            $TipoRecibo = $validated['TipoRecibo'];
            $Cantidad = $validated['Cantidad'];
            $Importe = $validated['Importe'];
            $Fecha = $validated['Fecha'];
            $Instruccion = $validated['Instruccion'];
            $IdInstructor = $validated['IdInstructor'] ?? null;  // Puede ser null
            $Itinerarios = $validated['Itinerarios'];
            $Datos = $validated['Datos'];  // Este es el JSON de itinerarios
            $Observaciones = $validated['Observaciones'] ?? null;
            $Aeronave = $validated['Aeronave'];
            $Tarifa = $validated['Tarifa'];
            $TipoItinerario = $validated['TipoItinerario'];

            // Llamar al procedimiento almacenado y pasar los parámetros
            $result = DB::select('CALL GenerarRecibo(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [
                $IdUsuario,
                $TipoRecibo,
                $Cantidad,
                $Importe,
                $Fecha,
                $Instruccion,
                $IdInstructor,
                $Itinerarios,
                $Datos,
                $Observaciones,
                $Aeronave,
                $Tarifa,
                $TipoItinerario
            ]);

            // Si se desea, puedes devolver una respuesta con algún mensaje o los resultados
            return response()->json(['message' => 'Recibo generado con éxito', 'data' => $result], 200);

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Manejo de errores de validación
            return response()->json(['error' => 'Datos de entrada inválidos', 'message' => $e->errors()], 422);
        } catch (\PDOException $e) {
            // Manejo de errores en la base de datos (como un error en el procedimiento almacenado)
            return response()->json(['error' => 'Error en la base de datos', 'message' => $e->getMessage()], 500);
        } catch (\Exception $e) {
            // Manejo de errores generales
            return response()->json(['error' => 'Error interno', 'message' => $e->getMessage()], 500);
        }
    }

    public function pagarRecibos(Request $request)
    {
        try {
            // Validar los parámetros que esperamos recibir
            $validated = $request->validate([
                'ids_movimientos' => 'required|string' // Validamos que venga como una cadena de texto
            ]);

            // Extraer y procesar los IDs de movimientos
            $idsMovimientos = explode(',', $validated['ids_movimientos']);

            // Validar que todos los elementos sean números enteros
            if (!collect($idsMovimientos)->every(fn($id) => is_numeric($id))) {
                return response()->json([
                    'error' => 'Los IDs de movimientos deben ser números enteros separados por punto y coma.'
                ], 422);
            }

            // Llamar al procedimiento almacenado con los IDs
            $result = DB::select('CALL ProcesarPagoRecibos(?)', [implode(',', $idsMovimientos)]);

            // Devolver respuesta exitosa con el resultado
            return response()->json([
                'message' => 'Recibos pagados con éxito.',
                'data' => $result
            ], 200);

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Manejo de errores de validación
            return response()->json(['error' => 'Datos de entrada inválidos', 'message' => $e->errors()], 422);
        } catch (\PDOException $e) {
            // Manejo de errores en la base de datos (como un error en el procedimiento almacenado)
            return response()->json(['error' => 'Error en la base de datos', 'message' => $e->getMessage()], 500);
        } catch (\Exception $e) {
            // Manejo de errores generales
            return response()->json(['error' => 'Error interno', 'message' => $e->getMessage()], 500);
        }
    }


}