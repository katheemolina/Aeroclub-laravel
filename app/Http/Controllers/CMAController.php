<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CMAController extends Controller
{
    /**
     * Obtener el estado de CMA por ID de usuario.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function obtenerEstadoCMA($id)
    {
        // Llama al stored procedure y obtiene el resultado
        $resultado = DB::select('CALL ObtenerEstadoCMAPorUsuario(?)', [$id]);

        // Verifica si hay resultados
        if (count($resultado) > 0) {
            return response()->json([
                'estado' => $resultado[0]->estado,
                'fecha_vencimiento_cma' => $resultado[0]->fecha_vencimiento_cma,
            ]);
        } else {
            return response()->json([
                'error' => 'Usuario no encontrado o sin fecha de vencimiento.'
            ], 404);
        }
    }
}
