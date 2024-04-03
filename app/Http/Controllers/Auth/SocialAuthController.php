<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\MediaObject;
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
            $checkIfAuthExist = UserSocialAuth::where('provider_id', $user->id)->first();
            $checkIfUserExist = User::where('email', $user->email)->first();
            if ((bool) $checkIfAuthExist) {
                Auth::login($checkIfAuthExist->user);
            } else {
                if ((bool) $checkIfUserExist) {
                    UserSocialAuth::create([
                        'user_id' => $checkIfUserExist->id,
                        'provider' => 'facebook',
                        'provider_id' => $user->id,
                    ]);
                    Auth::login($checkIfUserExist);
                } else {
                    $mediaObject = MediaObject::first();
                    $newUser = User::create([
                        'name' => $user->name,
                        'email' => $user->email,
                        'username' => Str::slug($user->name),
                        'password' => Hash::make(Str::random(24).time()),
                        'media_object_id' => $mediaObject->id,
                    ]);
                    UserSocialAuth::create([
                        'user_id' => $newUser->id,
                        'provider' => 'facebook',
                        'provider_id' => $user->id,
                    ]);
                    Auth::login($newUser);
                }
            }

            return redirect()->route('home');
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
