<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MovimientoController extends Controller
{
    public function sumaMovimientosPorUsuario($id_usuario)
    {
        try {
            // Llamar al procedimiento almacenado
            $result = DB::select('CALL SumarMovimientosPorUsuario(?)', [$id_usuario]);

            // Verificar si se obtuvo un resultado
            if (empty($result)) {
                return response()->json(['message' => 'No se encontraron movimientos para este usuario.'], 404);
            }

            // Retornar el resultado
            return response()->json([
                'id_usuario' => $id_usuario,
                'suma_total' => $result[0]->suma_total,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error interno del servidor'], 500);
        }
    }
}
