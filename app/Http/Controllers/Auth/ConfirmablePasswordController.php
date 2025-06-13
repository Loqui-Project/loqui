<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

final class ConfirmablePasswordController extends Controller
{
    /**
     * Confirm the user's password.
     */
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $request->validate([
                'password' => [
                    'required',
                    'string',
                    'current-password:api',
                ],
            ]);

            return $this->responseFormatter->responseSuccess(
                'Password confirmed successfully.',
            );
        } catch (Exception $e) {
            return $this->responseFormatter->responseError(
                $e->getMessage(),
                $e->getCode() ?: 500
            );
        }
    }
}
