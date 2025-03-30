<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Enums\SocialProvidersEnum;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserSocialAuth;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

final class SocialAuthController extends Controller
{
    /**
     * Redirect the user to the provider authentication page.
     */
    public function redirectToProvider(string $provider): \Symfony\Component\HttpFoundation\RedirectResponse|\Illuminate\Http\RedirectResponse
    {
        if (! in_array($provider, array_column(SocialProvidersEnum::cases(), 'value'))) {
            abort(404);
        }
        $provider = mb_strtolower($provider);

        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from provider.
     */
    public function handleProviderCallback(string $provider): \Illuminate\Http\RedirectResponse
    {
        if (! in_array($provider, array_column(SocialProvidersEnum::cases(), 'value'))) {
            abort(404);
        }
        $socialUser = Socialite::driver($provider)->user();

        if ($user = User::where('email', $socialUser->getEmail())->first()) {
            Auth::login($user);
            UserSocialAuth::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'provider' => $provider,
                    'provider_id' => $socialUser->getId(),
                ],
                [
                    'provider' => $provider,
                    'provider_id' => $socialUser->getId(),
                ]
            );
        } else {
            $user = User::create([
                'name' => $socialUser->getName(),
                'email' => $socialUser->getEmail(),
                'username' => $socialUser->getEmail(),
                'password' => Hash::make(Str::random(24).time()),
            ]);
            $user->assignRole('user');
            UserSocialAuth::create([
                'user_id' => $user->id,
                'provider' => $provider,
                'provider_id' => $socialUser->getId(),
            ]);

            Auth::login($user);
        }

        return to_route('home');
    }

    /**
     * Disconnect provider from user account.
     */
    public function disconnectProvider(string $provider): \Illuminate\Http\JsonResponse
    {
        try {
            $user = type(Auth::user())->as(User::class);
            UserSocialAuth::where('user_id', $user->id)
                ->where('provider', $provider)
                ->delete();

            return response()->json(['message' => 'Provider disconnected']);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
