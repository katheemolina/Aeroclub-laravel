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
        $resultado = DB::select('CALL ObtenerIdUsuarioDesdeMail(?, ?, ?)', [
            $email,
            $nombre,
            $apellido
        ]);

        // Retornar el resultado
        return response()->json($resultado);
    }


}