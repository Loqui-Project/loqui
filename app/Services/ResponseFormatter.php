<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;

final class ResponseFormatter
{
    /**
     * Response error.
     */
    public function responseError(string $message, int $code = 500): JsonResponse
    {
        return Response::json(['status' => 'error', 'message' => $message], $code);
    }

    /**
     * Response success.
     */
    public function responseSuccess(string $message, mixed $data = [], int $code = 200): JsonResponse
    {
        return Response::json(['status' => 'success', 'message' => $message, 'data' => $data], $code);
    }
}
