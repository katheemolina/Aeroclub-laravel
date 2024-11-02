<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class VuelosController extends Controller
{
    /**
     * Obtener la cantidad de horas voladas por ID de usuario.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */

     public function horasVoladasPorUsuario($idUsuario)
     {
         $result = DB::select('CALL HorasVoladasPorUsuario(?)', [$idUsuario]);
 
         if (empty($result)) {
             return response()->json(['message' => 'Usuario no encontrado.'], 404);
         }
 
         return response()->json($result);
     }
 
    /**
    * Obtener el ultimo vuelo por aeronave por usuario para evaluar si esta adaptado.
    *
    * @param  int  $id
    * @return \Illuminate\Http\JsonResponse
    */
    public function ultimosVuelosPorUsuario($idUsuario)
    {
        $result = DB::select('CALL UltimosVuelosPorUsuario(?)', [$idUsuario]);

        if (empty($result)) {
            return response()->json(['message' => 'Usuario no encontrado.'], 404);
        }

        return response()->json($result);
    }
    
    
    /**
    * Obtener todos vuelos por ID de usuario.
    *
    * @param  int  $id
    * @return \Illuminate\Http\JsonResponse
    */
    public function obtenerLibroDeVueloPorUsuario($idUsuario)
    {
        $result = DB::select('CALL LibroDeVueloPorUsuario(?)', [$idUsuario]);

        if (empty($result)) {
            return response()->json(['message' => 'Usuario no encontrado.'], 404);
        }

        return response()->json($result);
    }


    public function obtenerTodosLosItinerarios($id = 0) // Valor predeterminado de 0
    {
    // Llamada al procedimiento almacenado
    $result = DB::select('CALL TodosLosItinerarios(?)', [$id]);

    // Verificar si el resultado está vacío
    if (empty($result)) {
        return response()->json(['message' => 'No se encontraron itinerarios para el usuario.'], 404);
    }

    // Retornar el resultado en formato JSON
    return response()->json($result);
    }

}
