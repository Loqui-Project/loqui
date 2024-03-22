<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface UserFollowerRepositoryInterface
{
    /**
     * Get all follower users
     */
    public function getAllFollowerUsers(int $id): Collection;

    /**
     * Add user to follower list
     */
    public function addFollowerUser(int $userId, int $followId): bool;

    /**
     * Remove user from follower list
     */
    public function removeFollowerUser(int $userId, int $followId): bool;
}
