<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function success(mixed $data, string $message = 'okay', int $statusCode = 200): JsonResponse
    {
        return response()->json([
            'data' => $data,
            'success' => true,
            'message' => $message
        ], $statusCode);
    }

    public function error(string $message = 'Une erreur inconnue s\'est produite', int $statusCode = 500): JsonResponse
    {
        return response()->json([
            'data' => null,
            'success' => false,
            'message' => $message
        ], $statusCode);
    }
}
