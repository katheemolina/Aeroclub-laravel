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
            'fecha_adquisicion' => 'required|date_format:Y-m-d H:i:s',
            'consumo_por_hora' => 'required|numeric',
        ]);

        // Extraer los datos validados
        $marca = $validated['marca'];
        $modelo = $validated['modelo'];
        $matricula = $validated['matricula'];
        $potencia = $validated['potencia'];
        $clase = $validated['clase'];
        $fechaAdquisicion = $validated['fecha_adquisicion'];
        $consumoHora = $validated['consumo_por_hora'];

        // Ejecutar el procedimiento almacenado InsertarAeronaves
        DB::select('CALL InsertarAeronaves(?, ?, ?, ?, ?, ?, ?)', [
            $marca, 
            $modelo, 
            $matricula, 
            $potencia, 
            $clase, 
            $fechaAdquisicion, 
            $consumoHora
        ]);

        // Retornar una respuesta de éxito
        return response()->json([
            'message' => 'Aeronave insertada correctamente'
        ], 201); // Código de estado 201 para recurso creado
    }

    
    public function actualizarAeronave(Request $request, $id)
    {
        // Validar los datos recibidos
        $validatedData = $request->validate([
            'marca' => 'required|string|max:100',
        'modelo' => 'required|string|max:100',
        'matricula' => 'required|string|max:100',
        'potencia' => 'required|integer',
        'clase' => 'required|string|max:100',
        'fecha_adquisicion' => 'required|date_format:Y-m-d H:i:s',
        'consumo_por_hora' => 'required|numeric',
        'estado' => 'required|string|max:100',
        ]);

        // Llamada al procedimiento almacenado
        DB::statement('CALL ActualizarAeronaves(?, ?, ?, ?, ?, ?,?, ?, ?)', [
            $id, // El ID de la aeronave que se pasa por URL o cuerpo de la solicitud
        $validatedData['marca'],
        $validatedData['modelo'],
        $validatedData['matricula'],
        $validatedData['potencia'],
        $validatedData['clase'],
        $validatedData['fecha_adquisicion'],
        $validatedData['consumo_por_hora'],
        $validatedData['estado']
        ]);

        // Retornar una respuesta de éxito
        return response()->json(['message' => 'okkkkkkkkkkkkk.'], 200);
    }
}
