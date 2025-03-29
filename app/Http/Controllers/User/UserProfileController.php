<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\MessageResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

final class UserProfileController extends Controller
{
    /**
     * Display the user profile.
     */
    public function profile(Request $request, User $user): \Inertia\Response
    {
        $user = $user->loadCount([
            'messages',
            'followers',
            'following',
        ]);
        if (Auth::check() === false) {
            return $this->publicProfile([
                'user' => new UserResource($user),
                'is_me' => false,
                'messages' => MessageResource::collection($user->messages()->paginate()),
                'is_following_me' => $user->following()->where('user_id', Auth::id())->exists(),
                'is_following' => $user->followers()->where('follower_id', Auth::id())->exists(),
                'statistics' => [
                    'messages' => $user->messages_count,
                    'followers' => $user->followers_count ?? 0,
                    'following' => $user->following_count ?? 0,
                ],
            ]);
        }

        if (Auth::check() && Auth::id() !== $user->id) {

            return $this->publicProfile([
                'user' => new UserResource($user),
                'is_me' => false,
                'messages' => MessageResource::collection($user->messages()->paginate()),
                'is_following_me' => $user->following()->where('user_id', Auth::id())->exists(),
                'is_following' => $user->followers()->where('follower_id', Auth::id())->exists(),
                'statistics' => [
                    'messages' => $user->messages_count,
                    'followers' => $user->followers_count,
                    'following' => $user->following_count,
                ],
            ]);
        }

        return $this->myProfile([

            'user' => new UserResource($user),
            'is_me' => true,
            'messages' => MessageResource::collection($user->messages()->paginate()),
            'is_following_me' => false,
            'statistics' => [
                'messages' => $user->messages_count,
                'followers' => $user->followers_count,
                'following' => $user->following_count,
            ],
        ]);

    }

    public function myProfile($data)
    {
        return Inertia::render('user/my-profile', $data);
    }

    public function publicProfile($data)
    {
        return Inertia::render('user/public-profile', $data);

    }
}
