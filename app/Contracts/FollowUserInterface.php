<?php

declare(strict_types=1);

namespace App\Contracts;

use App\Models\User;

interface FollowUserInterface
{
    public function followUser(User $user, User $currentUser);

    public function unfollowUser(User $user, User $currentUser);
}
