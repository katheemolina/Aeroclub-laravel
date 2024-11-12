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
                'IdInstructor' => 'required|integer',
                'Itinerarios' => 'required|integer',  // Número de itinerarios
                'Datos' => 'required|string|max:1000',  // JSON con la información de itinerarios
                'Observaciones' => 'nullable|string|max:255',
                'Aeronave' => 'required|integer',
                'Tarifa' => 'required|integer',
            ]);

            // Extraer los datos validados
            $IdUsuario = $validated['IdUsuario'];
            $TipoRecibo = $validated['TipoRecibo'];
            $Cantidad = $validated['Cantidad'];
            $Importe = $validated['Importe'];
            $Fecha = $validated['Fecha'];
            $Instruccion = $validated['Instruccion'];
            $IdInstructor  = $validated['IdInstructor'];
            $Itinerarios = $validated['Itinerarios'];
            $Datos = $validated['Datos'];  // Este es el JSON de itinerarios
            $Observaciones = $validated['Observaciones'] ?? null;
            $Aeronave = $validated['Aeronave'];
            $Tarifa = $validated['Tarifa'];

            // Llamar al procedimiento almacenado y pasar los parámetros
            $result = DB::select('CALL GenerarRecibo(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [
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
                $Tarifa
            ]);

            // Si se desea, puedes devolver una respuesta con algún mensaje o los resultados
            return response()->json(['message' => 'Recibo generado con éxito', 'data' => $result], 200);
        } catch (\Exception $e) {
            // Manejo de errores, si algo sale mal
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}