<?php

namespace App\Traits;

use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as ResponsetatusCode;

trait ApiResponse
{
    private const MESSAGE_FETCHED = '';
    private const MESSAGE_CREATED = '';
    private const MESSAGE_UPDATED = '';
    private const MESSAGE_DELETED = '';

    private const ERROR_FETCHED = '';
    private const ERROR_CREATED = '';
    private const ERROR_UPDATED = '';
    private const ERROR_DELETED = '';
    private function successResponse(string $message, array $data = [], $code = ResponsetatusCode::HTTP_OK): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'type' => 'success',
            'title' => '',
            'message' => $message,
            'data' => $data,
        ], $code);
    }
    private function errorResponse(string $message, $code = ResponsetatusCode::HTTP_INTERNAL_SERVER_ERROR): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'type' => 'error',
            'title' => '',
            'message' => $message,
        ], $code);
    }
}
