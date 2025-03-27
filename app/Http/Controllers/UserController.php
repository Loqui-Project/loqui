<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\MessageResource;
use App\Http\Resources\UserResource;
use App\Jobs\NewFollowJob;
use App\Models\User;
use App\Models\UserFollow;
use Exception;
use Illuminate\Http\Request;
use Inertia\Inertia;

final class UserController extends Controller
{
    /**
     * Display the user profile.
     */
    public function profile(Request $request, User $user): \Inertia\Response
    {
        $messages = $user->messages()->with('user')->withReplies()->latest()->get();

        if ($request->user() === null) {
            return Inertia::render('profile', [
                'user' => new UserResource($user),
                'is_me' => false,
                'messages' => MessageResource::collection($messages),
                'is_following' => false,
                'statistics' => [
                    'messages' => $user->messages()->withReplies()->count(),
                    'followers' => $user->followers()->count(),
                    'following' => $user->followings()->count(),
                ],
            ]);
        }
        $authUser = type($request->user())->as(User::class);
        $is_me = $authUser->is($user);

        return Inertia::render('profile', [
            'user' => new UserResource($user),
            'is_me' => $is_me,
            'messages' => MessageResource::collection($messages),
            'is_following' => $request->user()?->isFollowing($user),
            'statistics' => [
                'messages' => $user->messages()->withReplies()->count(),
                'followers' => $user->followers()->count(),
                'following' => $user->followings()->count(),
            ],
        ]);
    }

    /**
     * Follow a user.
     */
    public function follow(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $authUser = type($request->user())->as(User::class);
            UserFollow::create([
                'user_id' => $request->user_id,
                'follower_id' => $authUser->id,
            ]);
            $user = type(User::find($request->user_id))->as(User::class);
            NewFollowJob::dispatch($user, $authUser);

            return response()->json(['message' => 'Followed successfully']);

        } catch (Exception $e) {

            return response()->json(['message' => $e->getMessage()], 500);
        }

    }

    /**
     * Unfollow a user.
     */
    public function unfollow(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $user = type($request->user())->as(User::class);

            UserFollow::where('user_id', $request->user_id)
                ->where('follower_id', $user->id)
                ->delete();

            return response()->json(['message' => 'Unfollowed successfully']);

        } catch (Exception $e) {

            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the followers of a user.
     */
    public function followers(Request $request, User $user): \Illuminate\Http\JsonResponse
    {

        $query = type($request->query('query') ?? '')->asString();

        $followers = $user->followers()
            ->withWhereHas('user', function ($queryBuilder) use ($query) {
                $queryBuilder->where('name', 'like', "%$query%")
                    ->orWhere('username', 'like', "%$query%");
            })
            ->get()->map(fn ($follow) => new UserResource($follow->follower))->flatten();

        return response()->json($followers);
    }

    /**
     * Display the followings of a user.
     */
    public function followings(Request $request, User $user): \Illuminate\Http\JsonResponse
    {
        $query = type($request->query('query') ?? '')->asString();

        $followings = $user->followings()
            ->withWhereHas('user', function ($queryBuilder) use ($query) {
                $queryBuilder->where('name', 'like', "%$query%")
                    ->orWhere('username', 'like', "%$query%");
            })
            ->get()->map(fn ($follow) => new UserResource($follow->follower))->flatten();

        return response()->json($followings);
    }
}
