<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class IngresoController extends Controller
{

    /**
     * Ejecuta el procedimiento almacenado para verificar o crear un usuario.
     */
    public function verificarOCrearUsuario(Request $request)
    {
        // Validar los datos de entrada
        $request->validate([
            'email' => 'required|email|max:200',
            'nombre' => 'required|string|max:200',
            'apellido' => 'required|string|max:200'
        ]);

        // Obtener los parámetros de la solicitud
        $email = $request->input('email');
        $nombre = $request->input('nombre');
        $apellido = $request->input('apellido');

        // Ejecutar el procedimiento almacenado
        $resultado = DB::select('CALL VerificarOCrearUsuario(?, ?, ?)', [
            $email,
            $nombre,
            $apellido
        ]);

        // Retornar el resultado
        return response()->json($resultado);
    }


    public function obtenerIdUsuarioDesdeMail($email)
    {
        // Ejecutar el procedimiento almacenado
        $result = DB::select(
            'CALL ObtenerIdUsuarioDesdeMail(?)', 
            [$email]
        );

        // Retornar el resultado en JSON
        if (!empty($result)) {
            return response()->json($result[0]); // Retorna el primer elemento del resultado
        } else {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }
    }

    public function obtenerEstadoDelUsuario($id)
    {
        try {
            // Llamar al procedimiento almacenado
            $estado = DB::select('CALL ObtenerEstadoDelUsuario(?)', [$id]);

            // Verificar si se obtuvo un resultado
            if (empty($estado)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Usuario no encontrado.',
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $estado[0], // Primer resultado
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener el estado del usuario.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


}