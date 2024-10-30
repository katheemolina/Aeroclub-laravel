<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UsuariosController extends Controller
{
    public function obtenerDatosDelUsuario($id)
    {
        // Llamar al Stored Procedure
        $result = DB::select('CALL ObtenerDatosDelUsuario(?)', [$id]);

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
    public function obtenerLibroDeVueloPorUsuario($id)
    {
        // Llamar al Stored Procedure
        $result = DB::select('CALL LibroDeVueloPorUsuario(?)', [$id]);

        if (empty($result)) {
            return response()->json(['message' => 'Usuario no encontrado.'], 404);
        }

        return response()->json($result);
    }

    public function obtenerTodosLosAsociados()
    {
        // Llamar al Stored Procedure
        $result = DB::select('CALL ListarAsociados()');

        if (empty($result)) {
            return response()->json(['message' => 'Usuario no encontrado.'], 404);
        }

        return response()->json($result);
    }
}
