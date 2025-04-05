<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Jobs\NewFollowJob;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

final class UserController extends Controller
{
    /**
     * Follow a user.
     */
    public function follow(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $authUser = type(Auth::user())->as(User::class);
            $authUser->following()->attach($request->user_id);
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

            $user = type(Auth::user())->as(User::class);
            $user->following()->detach($request->user_id);

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

        $followers = Cache::remember("user.{$user->id}.followers", 600, function () use ($user) {
            return $user->followers()->get()->map(fn (User $user): UserResource => new UserResource($user));
        }, 300);

        return response()->json($followers);
    }

    /**
     * Display the followings of a user.
     */
    public function followings(Request $request, User $user): \Illuminate\Http\JsonResponse
    {

        $followings = Cache::remember("user.{$user->id}.followings", 600, function () use ($user) {
            return $user->following()->get()->map(fn (User $user): UserResource => new UserResource($user));
        }, 300);

        return response()->json($followings);
    }
}
