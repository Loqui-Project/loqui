<?php

namespace App\Repositories;

use App\Interfaces\UserFollowingRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Models\UserFollow;
use App\Models\UserFollowing;
use Illuminate\Database\Eloquent\Collection;

class UserFollowingRepository implements UserFollowingRepositoryInterface
{
    protected UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Get all following users by user id
     */
    public function getAllFollowingUsers(int $id): Collection
    {
        $user = $this->userRepository->getUserById($id);
        $userFollowerList = $user->following()->get();
        return $userFollowerList;
    }

    /**
     * Add user to following list
     */
    public function addFollowingUser(int $userId, int $followId): bool
    {
        $checkIfUserFollowingAlready = UserFollow::where('follower_id', $userId)->where('following_id', $followId)->exists();
        if ($checkIfUserFollowingAlready) {
            return false;
        }

        $userFollowing = new UserFollow([
            'follower_id' =>  $userId,
            'following_id' => $followId,
        ]);
        return $userFollowing->save();
    }

    /**
     * Remove user from following list
     */
    public function removeFollowingUser(int $userId, int $followId): bool
    {
        $checkIfUserFollowing = UserFollow::where('follower_id', $userId)->where('following_id', $followId);
        if ($checkIfUserFollowing->exists()) {
            return $checkIfUserFollowing->delete();
        }
        return false;
    }
}
