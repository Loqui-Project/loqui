<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\FollowRequest;
use App\Http\Resources\MessageResource;
use App\Http\Resources\UserResource;
use App\Jobs\NewFollowJob;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

final class UserController extends Controller
{
    /**
     * Follow a user.
     *
     *
     *
     * @throws Exception
     */
    public function follow(FollowRequest $request): JsonResponse
    {
        try {
            $authUser = type($request->user())->as(User::class);
            $user = User::find($request->user_id);
            if ($user === null) {
                return $this->responseFormatter->responseError('User not found', 404);
            }
            /* @var User $user */
            $user = type($user)->as(User::class);

            $followingExists = $authUser->following()->where('user_id', $user->id)->exists();
            if ($followingExists) {
                return $this->responseFormatter->responseError('You are already following this user', 422);
            }
            if ($user->id === $authUser->id) {
                return $this->responseFormatter->responseError('You cannot follow yourself', 422);
            }
            $authUser->following()->attach($user->id);
            NewFollowJob::dispatch($user, $authUser);
            Cache::forget("user.{$user->id}.followings");
            Cache::forget("user.{$user->id}.statistics");

            return $this->responseFormatter->responseSuccess('Followed successfully', ['user' => new UserResource($user)]);
        } catch (Exception $e) {
            return $this->responseFormatter->responseError('Error following user', 500);
        }
    }

    /**
     * Unfollow a user.
     *
     *
     * @throws Exception
     */
    public function unfollow(Request $request): JsonResponse
    {
        try {
            $user = type($request->user())->as(User::class);

            $userToUnfollow = User::find($request->user_id);
            if ($userToUnfollow === null) {
                return $this->responseFormatter->responseError('User not found', 404);
            }

            /* @var User $userToUnfollow */
            $userToUnfollow = type($userToUnfollow)->as(User::class);

            if ($user->id === $userToUnfollow->id) {
                return $this->responseFormatter->responseError('You cannot unfollow yourself', 422);
            }
            $followingExists = $user->following()->where('user_id', $userToUnfollow->id)->exists();
            if (! $followingExists) {
                return $this->responseFormatter->responseError('You are not following this user', 422);
            }
            $user->following()->detach($userToUnfollow->id);
            Cache::forget("user.{$user->id}.followings");
            Cache::forget("user.{$userToUnfollow->id}.followers");
            Cache::forget("user.{$user->id}.statistics");
            Cache::forget("user.{$userToUnfollow->id}.statistics");

            return $this->responseFormatter->responseSuccess('Unfollowed successfully', ['user' => new UserResource($user)]);
        } catch (Exception $e) {

            return $this->responseFormatter->responseError('Error unfollowing user', 500);
        }
    }

    /**
     * Display the followings of a user.
     */
    public function followings(Request $request, User $user): JsonResponse
    {

        $followings = Cache::remember("user.{$user->id}.followings", 600, function () use ($user) {
            return $user->following()->get()->map(fn (User $user): UserResource => new UserResource($user));
        });

        return $this->responseFormatter->responseSuccess('Followings retrieved successfully', ['users' => $followings]);
    }

    public function getStatistics(Request $request, User $user): JsonResponse
    {
        $user->loadCount(['followers', 'following', 'messages']);
        $statistics = Cache::remember("user.{$user->id}.statistics", 600, function () use ($user) {
            return ['followers_count' => $user->followers()->count(), 'following_count' => $user->following()->count(), 'messages_count' => $user->messages()->count()];
        });

        return $this->responseFormatter->responseSuccess('User statistics retrieved successfully', ['statistics' => $statistics]);
    }

    /**
     * Display the followers of a user.
     */
    public function followers(Request $request, User $user): JsonResponse
    {
        $followers = Cache::remember("user.{$user->id}.followers", 600, function () use ($user) {
            return $user->followers()->get()->map(fn (User $user): UserResource => new UserResource($user));
        });

        return $this->responseFormatter->responseSuccess('Followers retrieved successfully', ['users' => $followers]);
    }

    public function messages(Request $request, User $user): JsonResponse
    {
        $messages = Cache::remember("user.{$user->id}.messages", 600, function () use ($user) {
            return $user->messages()->with(['user'])->withCount(['likes', 'replays'])->latest()->paginate(5);
        });

        return $this->responseFormatter->responseSuccess('User messages retrieved successfully', ['messages' => MessageResource::collection($messages)]);
    }
}
