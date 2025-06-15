<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\MessageResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

final class UserProfileController extends Controller
{
    /**
     * Display the user profile.
     */
    public function profile(Request $request, User $user): \Illuminate\Http\JsonResponse
    {
        $user = $user->loadCount([
            'messages',
            'followers',
            'following',
        ]);

        $messages = Cache::remember("user.{$user->id}.messages", 600, function () use ($user) {
            return $user->messages()->with(['user'])->withCount(['likes', 'replays'])->latest()->paginate(5);
        });
        $user->setRelation('messages', $messages);
        if ($request->user() === null) {
            return $this->responseFormatter->responseSuccess('user/public-profile', [
                'user' => new UserResource($user),
                'is_me' => false,
                'messages' => MessageResource::collection($user->messages),
                'is_following_me' => false,
                'is_following' => false,
                'statistics' => [
                    'messages' => $user->messages_count,
                    'followers' => $user->followers_count ?? 0,
                    'following' => $user->following_count ?? 0,
                ],
            ]);
        }
        /*  @var User $user */
        $authUser = $request->user();
        if ($authUser->id !== $user->id) {

            return $this->responseFormatter->responseSuccess('user/public-profile', [
                'user' => new UserResource($user),
                'is_me' => false,
                'messages' => MessageResource::collection($user->messages),
                'is_following_me' => $user->following()->where('user_id', $authUser->id)->exists(),
                'is_following' => $user->followers()->where('follower_id', $authUser->id)->exists(),
                'statistics' => [
                    'messages' => $user->messages_count,
                    'followers' => $user->followers_count,
                    'following' => $user->following_count,
                ],
            ]);
        }

        return $this->responseFormatter->responseSuccess('user/my-profile', [
            'user' => new UserResource($user),
            'is_me' => true,
            'messages' => MessageResource::collection($user->messages),
            'is_following_me' => false,
            'statistics' => [
                'messages' => $user->messages_count,
                'followers' => $user->followers_count,
                'following' => $user->following_count,
            ],
        ]);
    }
}
