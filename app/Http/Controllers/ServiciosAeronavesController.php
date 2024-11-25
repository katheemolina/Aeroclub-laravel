<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ServiciosAeronavesController extends Controller
{

    public function insertarServicio(Request $request)
{
    // Validar los datos recibidos
    $validated = $request->validate([
        'fecha' => 'required|date',               // Fecha debe ser un campo de tipo fecha
        'horas_anteriores' => 'required|numeric', // Horas anteriores debe ser un número
        'observaciones' => 'nullable|string|max:255', // Observaciones es opcional pero si está, debe ser texto y hasta 255 caracteres
        'id_aeronave' => 'required|integer',      // Id de la aeronave es obligatorio y debe ser entero
    ]);

    try {
        // Ejecutar el procedimiento almacenado InsertarServicios
        DB::select('CALL InsertarServicios(?, ?, ?, ?)', [
            $validated['fecha'],
            $validated['horas_anteriores'],
            $validated['observaciones'],
            $validated['id_aeronave']
        ]);

        // Retornar respuesta exitosa
        return response()->json([
            'status' => 'success',
            'message' => 'Servicio insertado correctamente'
        ]);
    } catch (\Exception $e) {
        // En caso de error, retornar un mensaje con el error
        return response()->json([
            'status' => 'error',
            'message' => 'Hubo un error al insertar el servicio',
            'error' => $e->getMessage()
        ], 500);
    }
}


public function actualizarServicio(Request $request, $id)
{
    // Validar los datos recibidos
    $validatedData = $request->validate([
        'fecha' => 'required|date_format:Y-m-d H:i:s',
        'observaciones' => 'required|string|max:255',
    ]);

    // Llamada al procedimiento almacenado ModificarServicios
    DB::statement('CALL ModificarServicios(?, ?, ?)', [
        $id,  // ID del servicio que se pasa como parámetro en la URL
        $validatedData['fecha'],
       
        $validatedData['observaciones'],

    ]);

    // Retornar una respuesta de éxito
    return response()->json(['message' => 'Servicio actualizado correctamente.'], 200);
}




    public function obtenerServicios($idAeronave)
{
    try {
        // Llamar al procedimiento almacenado con el parámetro IdAeronave
        $result = DB::select('CALL ObtenerServicios(?)', [$idAeronave]);

        // Verificar si no hay resultados
        if (empty($result)) {
            return response()->json(['message' => 'No se encontraron servicios para la aeronave especificada.'], 404);
        }

        // Retornar los resultados en formato JSON
        return response()->json($result, 200);

    } catch (\Exception $e) {
        // Manejo de errores
        return response()->json([
            'message' => 'Hubo un error al obtener los servicios.',
            'error' => $e->getMessage()
        ], 500);
    }
}
}