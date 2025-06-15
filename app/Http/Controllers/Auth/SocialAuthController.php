<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Enums\SocialProvidersEnum;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Models\UserSocialAuth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\AbstractProvider;

final class SocialAuthController extends Controller
{
    /**
     * Redirect the user to the provider authentication page.
     */
    public function connect(Request $request, string $provider): JsonResponse
    {
        if (! in_array($provider, array_column(SocialProvidersEnum::cases(), 'value'))) {
            return $this->responseFormatter->responseError('Invalid social provider.', 404);
        }

        $token = type($request->input('token'))->asString();

        $socialProvider = type(Socialite::driver($provider))->as(AbstractProvider::class);

        $socialUser = $socialProvider->userFromToken($token);

        $user = User::where('email', $socialUser->getEmail())->first();
        if ($user !== null) {
            UserSocialAuth::updateOrCreate(['user_id' => $user->id, 'provider' => $provider, 'provider_id' => $socialUser->getId()], ['provider' => $provider, 'provider_id' => $socialUser->getId()]);

        } else {
            $user = User::create(['name' => $socialUser->getName(), 'email' => $socialUser->getEmail(), 'username' => $socialUser->getEmail(), 'password' => Hash::make(Str::random(24).time())]);
            $user->assignRole('user');
            UserSocialAuth::create(['user_id' => $user->id, 'provider' => $provider, 'provider_id' => $socialUser->getId()]);
        }
        $accessToken = $user->createAccessToken()->plainTextToken;

        Auth::login($user);

        return $this->responseFormatter->responseSuccess('Social connection established successfully.', ['user' => new UserResource($user), 'access_token' => $accessToken]);
    }
}
