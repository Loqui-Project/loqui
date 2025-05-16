<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\FollowRequest;
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
     * @param FollowRequest $request
     *
     * @return JsonResponse
     *
     * @throws Exception
     */
    public function follow(FollowRequest $request): JsonResponse
    {
        try {
            $authUser = type($request->user())->as(User::class);
            $authUser->following()->attach($request->user_id);
            $user = User::find($request->user_id);
            NewFollowJob::dispatch($user, $authUser);

            return $this->responseFormatter->responseSuccess(
                'Followed successfully',
                [
                    'user' => new UserResource($user),
                ]
            );

        } catch (Exception $e) {
            return $this->responseFormatter->responseError(
                'Error following user',
                500
            );
        }

    }

    /**
     * Unfollow a user.
     *
     * @param Request $request
     * @return JsonResponse
     *
     * @throws Exception
     */
    public function unfollow(Request $request): JsonResponse
    {
        try {


            $user = type($request->user())->as(User::class);
            $user->following()->detach($request->user_id);

            return $this->responseFormatter->responseSuccess('Unfollowed successfully', [
                'user' => new UserResource($user),
            ]);

        } catch (Exception $e) {

            return $this->responseFormatter->responseError(
                'Error unfollowing user',
                500
            );
        }
    }

    /**
     * Display the followers of a user.
     * @param Request $request
     * @param User $user
     *
     * @return JsonResponse
     */
    public function followers(Request $request, User $user): JsonResponse
    {
        $followers = Cache::remember("user.{$user->id}.followers", 600, function () use ($user) {
            return $user->followers()->get()->map(fn (User $user): UserResource => new UserResource($user));
        }, 300);

        return $this->responseFormatter->responseSuccess(
            'Followers retrieved successfully',
            [
                'followers' => $followers,
            ]
        );
    }

    /**
     * Display the followings of a user.
     *
     * @param Request $request
     * @param User $user
     *
     * @return JsonResponse
     */
    public function followings(Request $request, User $user): JsonResponse
    {

        $followings = Cache::remember("user.{$user->id}.followings", 600, function () use ($user) {
            return $user->following()->get()->map(fn (User $user): UserResource => new UserResource($user));
        }, 300);

        return $this->responseFormatter->responseSuccess(
            'Followings retrieved successfully',
            [
                'followings' => $followings,
            ]
        );
    }
}
