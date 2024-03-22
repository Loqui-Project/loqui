<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;

class Handler extends Controller
{
    /**
     * Response error
     *
     * @param [type] $message
     * @param  int  $code
     */
    public function responseError($message, $code = 500): JsonResponse
    {
        return Response::json([
            'status' => 'error',
            'message' => $message,
        ], $code);
    }

    /**
     * Response success
     *
     * @param [type] $data
     * @param  int  $code
     */
    public function responseSuccess($data, $code = 200): JsonResponse
    {
        return Response::json([
            'status' => 'success',
            'data' => $data,
        ], $code);
    }
}
