<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class UsuariosController extends Controller
{
    /**
    * Obtener todos los datos del por ID de usuario.
    *
    * @param  int  $id
    * @return \Illuminate\Http\JsonResponse
    */

    public function obtenerDatosDelUsuario($id)
    {
        $result = DB::select('CALL ObtenerDatosDelUsuario(?)', [$id]);

        if (empty($result)) {
            return response()->json(['message' => 'Usuario no encontrado.'], 404);
        }

        return response()->json($result);
    }
    
    
    /**
     * Obtener el estado de CMA por ID de usuario.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */

     public function obtenerEstadoCMA($id)
     {
         // Ejecutar el procedimiento almacenado con el ID del usuario
         $result = DB::select('CALL ObtenerEstadoCMAPorUsuario(?)', [$id]);
     
         // Verificar si $resultado está vacío
         if (empty($result)) {
             return response()->json(['message' => 'Usuario no encontrado.'], 404);
         }
     
         // Devolver el resultado en JSON
         return response()->json($result);
     }
     

    /**
    * Obtener licencias de piloto por usuario.
    *
    * @param  int  $id
    * @return \Illuminate\Http\JsonResponse
    */
    public function obtenerLicenciasPorUsuario($id)
    {
        $result = DB::select('CALL ObtenerLicenciasPorUsuario(?)', [$id]);

        if (empty($result)) {
            return response()->json(['message' => 'Usuario no encontrado.'], 404);
        }

        return response()->json($result);
    }


    public function actualizarDatosDelUsuario(Request $request, $id)
    {
        // Validar los datos recibidos
        $validatedData = $request->validate([
            'telefono' => 'required|string|max:255',
            'dni' => 'required|integer',
            'estado' => 'required|in:Habilitado,Deshabilitado',
            'localidad' => 'required|string|max:255',
            'direccion' => 'required|string|max:255'
        ]);

        // Llamada al procedimiento almacenado
        DB::statement('CALL ActualizarDatosDelUsuario(?, ?, ?, ?, ?, ?)', [
            $id,
            $validatedData['telefono'],
            $validatedData['dni'],
            $validatedData['estado'],
            $validatedData['localidad'],
            $validatedData['direccion']
        ]);

        // Retornar una respuesta de éxito
        return response()->json(['message' => 'Datos del usuario actualizados con éxito.'], 200);
    }

    public function listarAsociados(Request $request)
    {
        // Obtener el ID del usuario desde la solicitud
        $id = $request->input('id', 0); // Usa 0 como valor por defecto

        // Llamada al procedimiento almacenado
        try {
            $result = DB::select('CALL ListarAsociados(?)', [$id]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al ejecutar el procedimiento: ' . $e->getMessage()], 500);
        }

        // Verificar si el resultado está vacío
        if (empty($result)) {
            return response()->json(['message' => 'No se encontraron asociados.'], 404);
        }

        // Retornar el resultado en formato JSON
        return response()->json($result);
    }


}
