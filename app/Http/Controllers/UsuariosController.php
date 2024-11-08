<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class UsuariosController extends Controller
{
    /**
    * Obtener todos los datos del por ID de usuario.
    *
    * @param  int  $id
    * @return \Illuminate\Http\JsonResponse
    */

    public function obtenerDatosDelUsuario($id)
    {
        $result = DB::select('CALL ObtenerDatosDelUsuario(?)', [$id]);

        if (empty($result)) {
            return response()->json(['message' => 'Usuario no encontrado.'], 404);
        }

        return response()->json($result);
    }
    
    
    /**
     * Obtener el estado de CMA por ID de usuario.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */

     public function obtenerEstadoCMA($id)
     {
         // Ejecutar el procedimiento almacenado con el ID del usuario
         $result = DB::select('CALL ObtenerEstadoCMAPorUsuario(?)', [$id]);
     
         // Verificar si $resultado está vacío
         if (empty($result)) {
             return response()->json(['message' => 'Usuario no encontrado.'], 404);
         }
     
         // Devolver el resultado en JSON
         return response()->json($result);
     }
     

    /**
    * Obtener licencias de piloto por usuario.
    *
    * @param  int  $id
    * @return \Illuminate\Http\JsonResponse
    */
    public function obtenerLicenciasPorUsuario($id)
    {
        $result = DB::select('CALL ObtenerLicenciasPorUsuario(?)', [$id]);

        if (empty($result)) {
            return response()->json(['message' => 'Usuario no encontrado.'], 404);
        }

        return response()->json($result);
    }

    public function actualizarLicencias(Request $request, $id)
    {
        // Validación de los datos
        $request->validate([
            'licencias' => 'required|array', // La lista de licencias debe estar en formato JSON
            'licencias.*.nombreLic' => 'required|string',
            'licencias.*.fechaVenc' => 'required|date',
        ]);

        try {
            // Convierte el array de licencias en JSON
            $licenciasJson = json_encode($request->input('licencias'));

            // Llama al procedimiento almacenado
            DB::statement('CALL ActualizarLicencias(?, ?)', [$id, $licenciasJson]);

            return response()->json(['message' => 'Licencias actualizadas correctamente.'], 200);
        } catch (Exception $e) {
            // Manejo de errores
            return response()->json(['error' => 'Error al actualizar licencias', 'message' => $e->getMessage()], 500);
        }
    }

    public function obtenerRolesPorUsuario($id)
    {
        $result = DB::select('CALL ObtenerRolesPorUsuario(?)', [$id]);

        if (empty($result)) {
            return response()->json(['message' => 'Usuario no encontrado.'], 404);
        }

        return response()->json($result);
    }

    public function actualizarDatosDelUsuario(Request $request, $id)
    {
        // Validar los datos de entrada
        $validated = $request->validate([
            'Telefono' => 'required|string|max:255',
            'Dni' => 'required|integer',
            'Localidad' => 'required|string|max:255',
            'Direccion' => 'required|string|max:255',
            'FechaNacimiento' => 'required|date',
            'FechaVencCMA' => 'required|date',
            'Licencias' => 'required|json',
            'CantHorasVuelo' => 'required|numeric',
            'CantAterrizajes' => 'required|integer',
        ]);

        try {
            // Ejecutar el stored procedure
            DB::beginTransaction();

            $resultado = DB::select('CALL ActualizarDatosDelUsuario(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [
                $id,  // El ID del usuario ahora es un parámetro en la URL
                $validated['Telefono'],
                $validated['Dni'],
                $validated['Localidad'],
                $validated['Direccion'],
                $validated['FechaNacimiento'],
                $validated['FechaVencCMA'],
                $validated['Licencias'],
                $validated['CantHorasVuelo'],
                $validated['CantAterrizajes'],
            ]);

            DB::commit();

            // Retornar una respuesta de éxito
            return response()->json([
                'message' => 'Datos del usuario actualizados correctamente.'
            ], 200);

        } catch (Exception $e) {
            DB::rollBack();

            // En caso de error, devolver un mensaje de error
            return response()->json([
                'message' => 'Error al actualizar los datos del usuario.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    

    public function listarAsociados(Request $request)
    {
        // Obtener el ID del usuario desde la solicitud
        $id = $request->input('id', 0); // Usa 0 como valor por defecto

        // Llamada al procedimiento almacenado
        try {
            $result = DB::select('CALL ListarAsociados(?)', [$id]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al ejecutar el procedimiento: ' . $e->getMessage()], 500);
        }

        // Verificar si el resultado está vacío
        if (empty($result)) {
            return response()->json(['message' => 'No se encontraron asociados.'], 404);
        }

        // Retornar el resultado en formato JSON
        return response()->json($result);
    }


    public function modificarEstadoAsociado(Request $request, $idUsuario)
{
    // Validar los datos recibidos
    $validatedData = $request->validate([
        'Estado' => 'required|string|in:habilitado,deshabilitado'  // Solo permite "habilitado" o "deshabilitado"
    ]);

    try {
        // Llamada al procedimiento almacenado
        DB::statement('CALL ModificarEstadoDeAsociado(?, ?)', [
            $idUsuario,                  // ID de usuario que se pasa como parámetro
            $validatedData['Estado']     // Estado recibido en la solicitud ("habilitado" o "deshabilitado")
        ]);

        // Retornar una respuesta de éxito
        return response()->json(['message' => 'Estado del asociado modificado exitosamente.'], 200);
    } catch (\Exception $e) {
        // Retornar una respuesta de error
        return response()->json(['error' => 'Error al modificar el estado del asociado: ' . $e->getMessage()], 500);
    }
}



}
