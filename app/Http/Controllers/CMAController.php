<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CMAController extends Controller
{
    public function obtenerEstadoCMA($id)
    {
        // Llamar al Stored Procedure
        $result = DB::select('CALL ObtenerEstadoCMA(?)', [$id]);

        if (empty($result)) {
            return response()->json(['message' => 'Usuario no encontrado.'], 404);
        }

        // Obtener el estado
        $estado_cma = $result[0]->estado_cma ?? 'Sin estado';

        return response()->json([
            'id_usuario' => $id,
            'estado_cma' => $estado_cma,
        ]);
    }
}
