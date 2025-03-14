<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserSocialAuth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    public function redirectToProvider($provider)
    {
        $provider = strtolower($provider);

        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider)
    {
        $socialUser = Socialite::driver($provider)->user();

        if ($user = User::where('email', $socialUser->email)->first()) {
            Auth::login($user);
            UserSocialAuth::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'provider' => $provider,
                    'provider_id' => $socialUser->id,
                ],
                [
                    'provider' => $provider,
                    'provider_id' => $socialUser->id,
                ]
            );
        } else {
            $user = User::create([
                'name' => $socialUser->name,
                'email' => $socialUser->email,
                'username' => $socialUser->email,
                'password' => Hash::make(Str::random(24).time()),
            ]);
            $user->assignRole('user');
            UserSocialAuth::create([
                'user_id' => $user->id,
                'provider' => $provider,
                'provider_id' => $socialUser->id,
            ]);

            Auth::login($user);
        }

        return redirect()->route('home');
    }

    public function disconnectProvider($provider)
    {
        try {
            $user = Auth::user();
            UserSocialAuth::where('user_id', $user->id)
                ->where('provider', $provider)
                ->delete();

            return response()->json(['message' => 'Provider disconnected']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
