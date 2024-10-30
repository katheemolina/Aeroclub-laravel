<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MovimientosController extends Controller
{
    public function obtenerTodosLosMovimientos()
    {
        // Llamar al Stored Procedure para obtener todos los movimientos
        $result = DB::select('CALL TodosLosMovimientos()');

        // Verificar si hay resultados
        if (empty($result)) {
            return response()->json(['message' => 'No se encontraron movimientos.'], 404);
        }

        return response()->json($result);
    }
}
