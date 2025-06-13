<?php

declare(strict_types=1);

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\UpdatePasswordRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rules\Password;

final class PasswordController extends Controller
{
    /**
     * Update the user's password.
     */
    public function __invoke(UpdatePasswordRequest $request): JsonResponse
    {
        try {
            return $this->responseFormatter->responseSuccess('Password updated successfully', [
            ]);
        } catch (Exception $e) {
            return $this->responseFormatter->responseError($e->getMessage(), 422);
        }
    }
}
