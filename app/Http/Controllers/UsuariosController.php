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
    // Validar la estructura de entrada
    $request->validate([
        '*.nombreLic' => 'required|string',
        '*.fechaVenc' => 'required|date'
    ]);

    // Convertir el JSON de licencias a una cadena para pasarla al procedimiento almacenado
    $licenciasJson = json_encode($request->all());

    // Llamar al procedimiento almacenado
    try {
        DB::statement('CALL ActualizarLicencias(?, ?)', [$id, $licenciasJson]);
        return response()->json(['message' => 'Licencias actualizadas exitosamente'], 200);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
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

    public function habilitarUsuario(Request $request)
    {
        try {
            // Validar que se haya recibido el IdUsuario en la solicitud
            $validated = $request->validate([
                'IdUsuario' => 'required|integer',
            ]);

            // Llamar al procedimiento almacenado pasando el IdUsuario como parámetro
            $IdUsuario = $validated['IdUsuario'];
            DB::statement('CALL HabilitarUsuario(?)', [$IdUsuario]);

            // Responder con un mensaje de éxito
            return response()->json(['message' => 'Usuario habilitado con éxito'], 200);
        } catch (\Exception $e) {
            // Manejar errores si ocurre alguno
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function deshabilitarUsuario(Request $request)
    {
        try {
            // Validar que se haya recibido el IdUsuario en la solicitud
            $validated = $request->validate([
                'IdUsuario' => 'required|integer',
            ]);

            // Llamar al procedimiento almacenado pasando el IdUsuario como parámetro
            $IdUsuario = $validated['IdUsuario'];
            DB::statement('CALL DeshabilitarUsuario(?)', [$IdUsuario]);

            // Responder con un mensaje de éxito
            return response()->json(['message' => 'Usuario deshabilitado con éxito'], 200);
        } catch (\Exception $e) {
            // Manejar errores si ocurre alguno
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function actualizarRoles(Request $request)
    {
        try {
            // Validar los datos de la solicitud
            $validated = $request->validate([
                'IdUsuario' => 'required|integer',
                'Roles' => 'required|json'
            ]);

            // Extraer los datos validados
            $IdUsuario = $validated['IdUsuario'];
            $Roles = $validated['Roles'];

            // Llamar al procedimiento almacenado
            DB::statement('CALL ActualizarRoles(?, ?)', [$IdUsuario, $Roles]);

            // Responder con un mensaje de éxito
            return response()->json(['message' => 'Roles actualizados con éxito'], 200);
        } catch (\Exception $e) {
            // Manejar cualquier error que ocurra
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function eliminarRol(Request $request)
    {
        try {
            // Validar los parámetros necesarios
            $validated = $request->validate([
                'IdUsuario' => 'required|integer',
                'IdRol' => 'required|integer'
            ]);

            // Extraer los valores validados
            $IdUsuario = $validated['IdUsuario'];
            $IdRol = $validated['IdRol'];

            // Llamar al procedimiento almacenado para eliminar el rol
            DB::statement('CALL EliminarRol(?, ?)', [$IdUsuario, $IdRol]);

            // Retornar una respuesta exitosa
            return response()->json(['message' => 'Rol eliminado correctamente'], 200);
        } catch (\Exception $e) {
            // Manejo de errores si algo sale mal
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }



}
