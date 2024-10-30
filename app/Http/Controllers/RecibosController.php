<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RecibosController extends Controller
{
    public function obtenerTodosLosRecibos()
    {
        // Llamar al Stored Procedure para obtener todos los recibos
        $result = DB::select('CALL TodosLosRecibos()');

        // Verificar si hay resultados
        if (empty($result)) {
            return response()->json(['message' => 'No se encontraron recibos.'], 404);
        }

        return response()->json($result);
    }
}
