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
    /**
     * Login Using Facebook
     */
    public function loginViaFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Callback From Facebook
     */
    public function callbackFromFacebook()
    {
        try {
            $user = Socialite::driver('facebook')->user();
            if ($user->getId()) {
                $checkIfAuthExist = UserSocialAuth::where('provider_id', $user->getId())->first();
                $checkIfUserExist = User::where('email', $user->getEmail())->first();
                if ((bool) $checkIfAuthExist) {
                    Auth::login($checkIfAuthExist->user);
                } else {
                    if ((bool) $checkIfUserExist) {
                        UserSocialAuth::create([
                            'user_id' => $checkIfUserExist->id,
                            'provider' => 'facebook',
                            'provider_id' => $user->getId(),
                        ]);
                        Auth::login($checkIfUserExist);
                    } else {
                        $newUser = User::create([
                            'name' => $user->getName(),
                            'email' => $user->getEmail(),
                            'username' => Str::slug($user->getName()),
                            'password' => Hash::make(Str::random(24).time()),
                        ]);
                        UserSocialAuth::create([
                            'user_id' => $newUser->id,
                            'provider' => 'facebook',
                            'provider_id' => $user->getId(),
                        ]);
                        Auth::login($newUser);
                    }
                }

                return redirect()->route('home');
            } else {
                return redirect()->route('login')->with('error', 'Failed to login via Facebook');
            }

        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
