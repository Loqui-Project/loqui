<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Enums\UserStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\UserResource;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

final class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming authentication request.
     *
     * @throws ValidationException
     */
    public function store(LoginRequest $request): JsonResponse
    {
        try {
            $request->authenticate();
            if ($request->user()->status === UserStatusEnum::DEACTIVATED) {
                return $this->responseFormatter->responseError('Your account is disabled.', 403);
            }

            return $this->responseFormatter->responseSuccess('Login successful', [
                'user' => new UserResource($request->user()),
                'access_token' => $request->user()->createAccessToken()->plainTextToken,
            ], 200);
        } catch (Exception $e) {
            return $this->responseFormatter->responseError($e->getMessage(), 422);
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): JsonResponse
    {

        try {
            $request->user()->currentAccessToken()->delete();
            return $this->responseFormatter->responseSuccess('Logout successful', [
            ], 200);
        } catch (Exception $e) {
            return $this->responseFormatter->responseError($e->getMessage(), 500);
        }
    }
}
