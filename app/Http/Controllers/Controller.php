<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function sendSuccessResponse($message, $statusCode = 200, $payload = []) {
        $body = array_merge([
            'status' => true,
            'message' => $message
        ], $payload);
        return response()->json($body, $statusCode);
    }

    protected function sendErrorResponse($message, $statusCode, $errors = []) {
        $body = array_merge([
            'status' => false,
            'message' => $message
        ], $errors);
        return response()->json($body, $statusCode);
    }
}
