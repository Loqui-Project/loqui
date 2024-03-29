<?php

namespace App\Repositories;

use App\Interfaces\UserFollowerRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Models\UserFollow;
use Illuminate\Database\Eloquent\Collection;

class UserFollowerRepository implements UserFollowerRepositoryInterface
{
    protected UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Get all follower users
     */
    public function getAllFollowerUsers(int $id): Collection
    {
        $user = $this->userRepository->getUserById($id);
        $userFollowerList = $user->follower()->get();

        return $userFollowerList;
    }

    /**
     * Add user to follower list
     */
    public function addFollowerUser(int $userId, int $followId): bool
    {
        $checkIfUserFollowAlready = UserFollow::where('follower_id', $followId)->where('following_id', $userId)->exists();
        if ($checkIfUserFollowAlready) {
            return false;
        }
        $userFollower = new UserFollow([
            'follower_id' => $followId,
            'following_id' => $userId,
        ]);

        return $userFollower->save();
    }

    /**
     * Remove user from follower list
     */
    public function removeFollowerUser(int $userId, int $followId): bool
    {
        $checkIfUserFollow = UserFollow::where('follower_id', $followId)->where('following_id', $userId);
        if ($checkIfUserFollow->exists()) {
            return $checkIfUserFollow->delete();
        }

        return false;
    }
}
