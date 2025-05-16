<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

final class RegisteredUserController extends Controller
{

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function __invoke(RegisterRequest $request): JsonResponse
    {

        $user = User::create($request->validated());
        $user->assignRole('user');
        event(new Registered($user));

        Auth::login($user);

        $token = $this->authService->getAccessToken([
            'username' => $request->input('email'),
            'password' => $request->input('password'),
        ]);

        return $this->responseFormatter->responseSuccess(
            'Registration successful',
            [
                'user' => new UserResource($user),
                'token' => $token,
            ],
            201
        );
    }
}
