<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface UserFollowingRepositoryInterface
{
    /**
     * Get all following users
     */
    public function getAllFollowingUsers(int $id): Collection;

    /**
     * Add user to following list
     */
    public function addFollowingUser(int $userId, int $followId): bool;

    /**
     * Remove user from following list
     */
    public function removeFollowingUser(int $userId, int $followId): bool;
}
