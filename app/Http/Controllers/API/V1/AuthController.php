<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\Handler;
use App\Http\Requests\API\Auth\SignInRequest;
use App\Http\Requests\API\Auth\SignUpRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Traits\UserOauthTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;

class AuthController extends Handler
{
    use UserOauthTrait;

    /**
     * Sign in request
     *
     * @param SignInRequest $request
     *
     * @return JsonResponse
     */
    public function signIn(SignInRequest $request): JsonResponse
    {
        try {
            $credentials = $request->getInput();
            if (! Auth::attempt([
                'email' => $credentials['email'],
                'password' => $credentials['password'],
            ], $credentials['remember_me'] ?? false)) {
                return $this->responseError('Unauthorized', 401);
            }

            /** @var \App\Models\User $user */
            $user = Auth::user();
            $token = $this->getAccessToken([
                'grant_type' => 'password',
                'client_id' => env('PASSPORT_CLIENT_ID'),
                'client_secret' => env('PASSPORT_CLIENT_SECRET'),
                'username' => $user->email,
                'password' => $credentials['password'],
                'scope' => '',
            ]);

            return $this->responseSuccess([
                'token' => $token,
                'user' => new UserResource($user),
            ]);
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage(), 500);
        }
    }

    /**
     * Sign Up Request
     *
     * @param \App\Http\Requests\API\SignUpRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function signUp(SignUpRequest $request): JsonResponse
    {
        try {
            $credentials = $request->getInput();
            $credentials['password'] = Hash::make($credentials['password']);
            $defaultImage = public_path("images/AnonImage.png");
            $placeHolderImage = Image::make($defaultImage);
            // move image to storage
            $placeHolderImage->save(public_path('storage/'.$placeHolderImage->basename));
            $mediaObjectData = [
                'media_path' => 'storage/' .$placeHolderImage->basename,
            ];
            $image = \App\Models\MediaObject::create($mediaObjectData);
            $credentials['media_object_id'] = $image->id;

            /** @var \App\Models\User $user */
            $user = User::create($credentials);
            Auth::login($user);
            $token = $this->getAccessToken([
                'grant_type' => 'password',
                'client_id' => env('PASSPORT_CLIENT_ID'),
                'client_secret' => env('PASSPORT_CLIENT_SECRET'),
                'username' => $user->email,
                'password' => $request->getInput()['password'],
                'scope' => '',
            ]);
            return $this->responseSuccess([
                'token' => $token,
                'user' => new UserResource($user),
            ], 201);
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage(), 500);
        }
    }

    /**
     * Sign out request
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function signOut(Request $request): JsonResponse
    {
        try {
            $request->user()->token()->revoke();

            return $this->responseSuccess([
                'message' => 'Successfully logged out',
            ]);
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage(), 500);
        }
    }
}
