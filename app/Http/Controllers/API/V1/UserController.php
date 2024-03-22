<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\Handler;
use App\Http\Requests\API\ProfileUpdateRequest;
use App\Http\Requests\API\User\Followers\AddUserToFollowersList;
use App\Http\Requests\API\User\Followers\RemoveUserFromFollowersList;
use App\Http\Requests\API\User\Following\AddUserToFollowingList;
use App\Http\Requests\API\User\Following\RemoveUserFromFollowingList;
use App\Http\Resources\UserResource;
use App\Interfaces\UserFollowerRepositoryInterface;
use App\Interfaces\UserFollowingRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Models\User;
use App\Notifications\NewFollowerNotification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class UserController extends Handler
{
    public function __construct(private UserRepositoryInterface $userRepository, private UserFollowingRepositoryInterface $userFollowingRepository, private UserFollowerRepositoryInterface $userFollowerRepository)
    {
    }

    /**
     *  Get My Profile
     */
    public function getMyProfile(Request $request): JsonResponse
    {
        $currentUser = $request->user("api");

        $userCache = Cache::store('redis')->remember('user:' . $currentUser->id . ":profile", 3600, function () use ($currentUser) {
            return $this->userRepository->getUserById($currentUser->id);
        });
        return $this->responseSuccess(new UserResource($userCache));
    }

    /**
     * Get following list for authenticated user
     */
    public function getFollowingList(Request $request): JsonResponse
    {
        $currentUser = $request->user("api");
        $userFollowingList = Cache::store('redis')->remember('user:' . $currentUser->id . ":profile:following_list", 3600, function () use ($currentUser) {
            return $this->userFollowingRepository->getAllFollowingUsers($currentUser->id);
        });
        return $this->responseSuccess(UserResource::collection($userFollowingList));
    }

    /**
     * Add user to following list
     *
     * @param  AddUserToFollowingList  $request
     */
    public function addUserToFollowingList(AddUserToFollowingList $request)
    {
        try {
            $currentUser = $request->user("api");
            $actionStatus = $this->userFollowingRepository->addFollowingUser($currentUser->id, $request->follow_id);
            if ($actionStatus) {
                Cache::store('redis')->forget('user:' . $currentUser->id . ":profile:following_list");
                $followUser = $this->userRepository->getUserById($request->follow_id);
                $followUser->notify(new NewFollowerNotification($currentUser, $followUser));
                return $this->responseSuccess(null, 201);
            } else {
                return $this->responseError('User is already following', 400);
            }
        } catch (\Throwable $th) {
            return $this->responseError('Error' . $th->getMessage(), 500);
        }
    }

    /**
     * Remove user to following list
     *
     * @param  Request  $request
     */
    public function removeUserFromFollowingList(RemoveUserFromFollowingList $request): JsonResponse
    {
        try {
            $currentUser = $request->user("api");
            $res = $this->userFollowingRepository->removeFollowingUser($currentUser->id, $request->follow_id);
            if ($res) {
                Cache::store('redis')->forget('user:' . $currentUser->id . ":profile:following_list");
                return $this->responseSuccess(null, 201);
            } else {
                return $this->responseError('User is not following', 400);
            }
        } catch (\Throwable $th) {
            return $this->responseError('Error' . $th->getMessage(), 500);
        }
    }

    /**
     * Get user followers list
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function getFollowersList(Request $request): JsonResponse
    {
        $currentUser = $request->user();
        $users = Cache::store('redis')->remember('user:' . $currentUser->id . ":profile:followers_list", 3600, function () use ($currentUser) {
            return  $this->userFollowerRepository->getAllFollowerUsers($currentUser->id);
        });
        return $this->responseSuccess(UserResource::collection($users));
    }


    /**
     * Add user to following list
     *
     * @param  AddUserToFollowersList  $request
     *
     * @return JsonResponse
     */
    public function addUserToFollowersList(AddUserToFollowersList $request): JsonResponse
    {
        try {
            $currentUser = $request->user();
            $actionStatus = $this->userFollowerRepository->addFollowerUser($currentUser->id, $request->follow_id);
            if ($actionStatus) {
                Cache::store('redis')->forget('user:' . $currentUser->id . ":profile:followers_list");

                return $this->responseSuccess(null, 201);
            } else {
                return $this->responseSuccess("You already follow this user", 400);
            }
        } catch (\Throwable $th) {
            return $this->responseError('Error' . $th->getMessage(), 500);
        }
    }

    /**
     * Remove user to following list
     *
     * @param  RemoveUserFromFollowersList  $request
     *
     *
     */
    public function removeUserFromFollowersList(RemoveUserFromFollowersList $request): JsonResponse
    {
        try {
            $currentUser = $request->user();
            $res = $this->userFollowerRepository->removeFollowerUser($currentUser->id, $request->follow_id);
            if ($res) {
                Cache::store('redis')->forget('user:' . $currentUser->id . ":profile:followers_list");
                return $this->responseSuccess(null, 201);
            } else {
                return $this->responseError('User is not follow you', 400);
            }
        } catch (\Throwable $th) {
            return $this->responseError('Error' . $th->getMessage(), 500);
        }
    }


    /**
     * Update user information
     *
     * @param  ProfileUpdateRequest  $request
     *
     * @return JsonResponse
     */
    public function updateUserInformation(ProfileUpdateRequest $request): JsonResponse
    {
        try {
            $currentUser = $request->user();
            $this->userRepository->updateUser($currentUser->id, $request->getInput());
            return $this->responseSuccess([
                'message' => "User information updated successfully."
            ], 201);
        } catch (\Throwable $th) {
            return $this->responseError('' . $th->getMessage(), 500);
        }
    }

    public function getUserProfile(string $username): JsonResponse|string
    {
        try {
            $user  = User::where('username', $username)->first();
            if (!$user) {
                return $this->responseError('User not found', 404);
            }
            return $this->responseSuccess(new UserResource($user));
        } catch (\Throwable $th) {
            return $this->responseError('' . $th->getMessage(), 500);
        }
    }
}
