<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ItinerariosController extends Controller
{
    public function obtenerTodosLosItinerarios()
    {
        // Llamar al Stored Procedure para obtener todos los itinerarios
        $result = DB::select('CALL TodosLosItinerarios()');

        // Verificar si hay resultados
        if (empty($result)) {
            return response()->json(['message' => 'No se encontraron itinerarios.'], 404);
        }

        return response()->json($result);
    }
}
