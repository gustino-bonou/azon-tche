<?php

namespace App\Http\Response;

class ApiResponse
{

    static public function errorResponse($messages, $statusCode = 500)
    {

        return response()->json([
            'data' => $messages,
            'success' => false,
        ], $statusCode);
    }
}
