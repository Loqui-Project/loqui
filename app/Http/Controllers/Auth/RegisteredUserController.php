<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Exception;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

final class RegisteredUserController extends Controller
{
    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function __invoke(RegisterRequest $request): JsonResponse
    {

        try {
            $user = User::create($request->validated());
            $user->assignRole('user');
            event(new Registered($user));

            Auth::login($user);

            return $this->responseFormatter->responseSuccess('Registered successfully', [], 200);
        } catch (Exception $e) {
            return $this->responseFormatter->responseError('Register failed', 500);
        }
    }
}
