<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{
    public function getArticulos()
    {
        try {
            // Ejecuta el procedimiento almacenado
            $articulos = DB::select('CALL test()');

            // Retorna los datos en formato JSON
            return response()->json($articulos);
        } catch (\Exception $e) {
            // Retorna un mensaje de error en caso de falla
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
