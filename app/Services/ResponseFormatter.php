<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;

final class ResponseFormatter
{
    /**
     * Response error.
     *
     * @param string $message
     * @param int $code
     * @return JsonResponse
     */
    public function responseError(string $message,  int $code = 500): JsonResponse
    {
        return Response::json(['status' => 'error', 'message' => $message], $code);
    }

    /**
     * Response success.
     *
     * @param string $message
     * @param mixed $data
     * @param int $code
     * @return JsonResponse
     */
    public function responseSuccess(string $message, mixed $data = [], int $code = 200): JsonResponse
    {
        return Response::json(['status' => 'success', 'message' => $message, 'data' => $data], $code);
    }
}
