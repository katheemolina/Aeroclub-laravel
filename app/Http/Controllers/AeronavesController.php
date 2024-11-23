<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class AeronavesController extends Controller
{

    public function obtenerAeronaves()
    {
        // Ejecutar el procedimiento almacenado ObtenerAeronaves
        $aeronaves = DB::select('CALL ObtenerAeronaves()');

        // Retornar los resultados en formato JSON
        return response()->json($aeronaves);
    }

    public function insertarAeronave(Request $request)
{
    // Validar los datos recibidos en la solicitud
    $validated = $request->validate([
        'marca' => 'required|string|max:100',
        'modelo' => 'required|string|max:100',
        'matricula' => 'required|string|max:100',
        'potencia' => 'required|integer',
        'clase' => 'required|string|max:100',
        'fecha_adquisicion' => 'required|date_format:Y-m-d',
        'consumo_por_hora' => 'required|numeric',
        'horas_historicas' => 'required|numeric',
        'intervalo_inspeccion' => 'required|numeric',
        'ultimo_servicio' => 'required|date_format:Y-m-d',
        'horas_vuelo_aeronave' => 'required|numeric',
        'horas_vuelo_motor' => 'required|numeric',
        'motor' => 'required|string|max:250',
        'aseguradora' => 'required|string|max:250',
        'numero_poliza' => 'required|string|max:250',
        'vencimiento_poliza' => 'required|date_format:Y-m-d',
    ]);

    // Extraer los datos validados
    $marca = $validated['marca'];
    $modelo = $validated['modelo'];
    $matricula = $validated['matricula'];
    $potencia = $validated['potencia'];
    $clase = $validated['clase'];
    $fechaAdquisicion = $validated['fecha_adquisicion'];
    $consumoHora = $validated['consumo_por_hora'];
    $horasHistoricas = $validated['horas_historicas'];
    $intervaloInspeccion = $validated['intervalo_inspeccion'];
    $ultimoServicio = $validated['ultimo_servicio'];
    $horasVueloAeronave = $validated['horas_vuelo_aeronave'];
    $horasVueloMotor = $validated['horas_vuelo_motor'];
    $motor = $validated['motor'];
    $aseguradora = $validated['aseguradora'];
    $numeroPoliza = $validated['numero_poliza'];
    $vencimientoPoliza = $validated['vencimiento_poliza'];

    // Ejecutar el procedimiento almacenado InsertarAeronaves
    try {
        DB::statement('CALL InsertarAeronaves(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?,?,?,?)', [
            $marca, 
            $modelo, 
            $matricula, 
            $potencia, 
            $clase, 
            $fechaAdquisicion, 
            $consumoHora, 
            $horasHistoricas, 
            $intervaloInspeccion, 
            $ultimoServicio, 
            $horasVueloAeronave, 
            $horasVueloMotor,
            $motor,
            $aseguradora,
            $numeroPoliza,
            $vencimientoPoliza,
        ]);

        // Retornar una respuesta de éxito
        return response()->json([
            'message' => 'Aeronave insertada correctamente'
        ], 201); // Código de estado 201 para recurso creado
    } catch (\Exception $e) {
        // Manejar cualquier error y devolver un mensaje adecuado
        return response()->json([
            'error' => 'Error al insertar la aeronave: ' . $e->getMessage()
        ], 500); // Código de estado 500 para error interno del servidor
    }
}

/*
    
    public function actualizarAeronave(Request $request, $id)
    {
        // Validar los datos recibidos
        $validatedData = $request->validate([
            'marca' => 'required|string|max:100',
        'modelo' => 'required|string|max:100',
        'matricula' => 'required|string|max:100',
        'potencia' => 'required|integer',
        'clase' => 'required|string|max:100',
        'fecha_adquisicion' => 'required|date_format:Y-m-d',
        'consumo_por_hora' => 'required|numeric',
        'estado' => 'required|string|max:100',
        'horas_historicas' => 'required|numeric',
        'intervalo_inspeccion' => 'required|numeric',
        'ultimo_servicio' => 'required|date_format:Y-m-d',
        'horas_vuelo_aeronave' => 'required|numeric',
        'horas_vuelo_motor' => 'required|numeric',
        'motor' => 'required|string|max:250',
        'aseguradora' => 'required|string|max:250',
        'numero_poliza' => 'required|string|max:250',
        'vencimiento_poliza' => 'required|date_format:Y-m-d',
        ]);

        // Llamada al procedimiento almacenado
        DB::statement('CALL ActualizarAeronaves(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [
            $id, // El ID de la aeronave que se pasa por URL
            $validatedData['marca'],
            $validatedData['modelo'],
            $validatedData['matricula'],
            $validatedData['potencia'],
            $validatedData['clase'],
            $validatedData['fecha_adquisicion'],
            $validatedData['consumo_por_hora'],
            $validatedData['estado'],
            $validatedData['horas_historicas'],
            $validatedData['intervalo_inspeccion'],
            $validatedData['ultimo_servicio'],
            $validatedData['horas_vuelo_aeronave'],
            $validatedData['horas_vuelo_motor'],
            $validatedData['motor'],
            $validatedData['aseguradora'],
            $validatedData['numero_poliza'],
            $validatedData['vencimiento_poliza']
        ]);

        // Retornar una respuesta de éxito
        return response()->json(['message' => 'okkkkkkkkkkkkk.'], 200);
    }
        */

        public function cambiarEstado($id)
    {
        try {
            // Llamar al procedimiento almacenado
            DB::statement('CALL cambiarEstadoAeronave(?)', [$id]);

            return response()->json([
                'success' => true,
                'message' => 'Estado de la aeronave cambiado exitosamente.',
            ], 200);
        } catch (\Illuminate\Database\QueryException $e) {
            // Manejar errores de SQL
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        } catch (\Exception $e) {
            // Manejar errores generales
            return response()->json([
                'success' => false,
                'message' => 'Ocurrió un error al cambiar el estado de la aeronave.',
            ], 500);
        }
    }


    public function cambiarDatosPoliza(Request $request)
    {
        // Validar los datos de entrada
        $validated = $request->validate([
            'id_aeronave' => 'required|integer|exists:aeronaves,id_aeronave',
            'aseguradora' => 'required|string|max:255',
            'numero_poliza' => 'required|string|max:255',
            'vencimiento_poliza' => 'required|date',
        ]);

        try {
            // Llamar al procedimiento almacenado
            DB::statement('CALL CambiarDatosPoliza(?, ?, ?, ?)', [
                $validated['id_aeronave'],
                $validated['aseguradora'],
                $validated['numero_poliza'],
                $validated['vencimiento_poliza'],
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Datos de la póliza actualizados exitosamente.',
            ], 200);
        } catch (\Illuminate\Database\QueryException $e) {
            // Manejar errores de SQL
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        } catch (\Exception $e) {
            // Manejar errores generales
            return response()->json([
                'success' => false,
                'message' => 'Ocurrió un error al actualizar los datos de la póliza.',
            ], 500);
        }
    }

    public function actualizarIntervaloInspeccion(Request $request)
    {
        // Validar los datos de entrada
        $validated = $request->validate([
            'id_aeronave' => 'required|integer|exists:aeronaves,id_aeronave',
            'intervalo_inspeccion' => 'required|numeric|min:0',
        ]);

        try {
            // Llamar al procedimiento almacenado
            DB::statement('CALL ActualizarIntervaloInspeccion(?, ?)', [
                $validated['id_aeronave'],
                $validated['intervalo_inspeccion'],
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Intervalo de inspección actualizado exitosamente.',
            ], 200);
        } catch (\Illuminate\Database\QueryException $e) {
            // Manejar errores de SQL
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        } catch (\Exception $e) {
            // Manejar errores generales
            return response()->json([
                'success' => false,
                'message' => 'Ocurrió un error al actualizar el intervalo de inspección.',
            ], 500);
        }
    }





    public function eliminarAeronave(Request $request)
    {
        try {
            // Validar el parámetro necesario
            $validated = $request->validate([
                'IdAeronave' => 'required|integer'
            ]);

            // Extraer el valor validado
            $IdAeronave = $validated['IdAeronave'];

            // Llamar al procedimiento almacenado para eliminar la aeronave
            DB::statement('CALL EliminarAeronave(?)', [$IdAeronave]);

            // Retornar una respuesta exitosa
            return response()->json(['message' => 'Aeronave eliminada correctamente'], 200);
        } catch (\Exception $e) {
            // Manejo de errores
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

}
