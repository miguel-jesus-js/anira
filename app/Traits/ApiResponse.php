<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseStatusCode;

trait ApiResponse
{
    private const MESSAGE_FETCHED = 'Datos cargado correctamente';
    private const MESSAGE_CREATED = 'Registro creado correctamente';
    private const MESSAGE_UPDATED = 'Registro actualizado correctamente';
    private const MESSAGE_DELETED = 'Registro eliminado correctamente';
    private const MESSAGE_EXPORT = 'Datos exportados correctamente';

    private const ERROR_FETCHED = 'Error al cargar los datos';
    private const ERROR_CREATED = 'Error al crear los datos';
    private const ERROR_UPDATED = 'Error al actualizar los datos';
    private const ERROR_DELETED = 'Error al eliminar los datos';
    private const ERROR_EXPORT = 'Error al exportar los datos';


    /**
     * @param string $message
     * @param array $data
     * @param int $code
     * @return JsonResponse
     */
    private function successResponse(string $message, array $data = [], int $code = ResponseStatusCode::HTTP_OK): JsonResponse
    {
        return response()->json([
            'type' => 'success',
            'title' => 'Éxito',
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    /**
     * @param string $message
     * @param int $code
     * @return JsonResponse
     */
    private function errorResponse(string $message, int $code = ResponseStatusCode::HTTP_INTERNAL_SERVER_ERROR): JsonResponse
    {
        return response()->json([
            'type' => 'error',
            'title' => 'Error',
            'message' => $message,
        ], $code);
    }
}
