<?php

namespace App\Traits;

use App\Models\User;
use App\Models\UserFollow;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

trait HasFollow
{
    public function following(): HasManyThrough
    {
        return $this->hasManyThrough(
            User::class,
            UserFollow::class,
            "follower_id",
            "id",
            "id",
            "following_id",
        );
    }

    public function followers(): HasManyThrough
    {
        return $this->hasManyThrough(
            User::class,
            UserFollow::class,
            "following_id",
            "id",
            "id",
            "follower_id",
        );
    }

    public function isFollowing(User $user)
    {
        return $this->following->contains("following_id", $user->id);
    }

    public function followUser(User $user, User $currentUser)
    {
        if (!$this->isFollowing($user)) {
            UserFollow::create([
                "follower_id" => $currentUser->id,
                "following_id" => $user->id,
            ]);
        }
    }

    public function unfollowUser(User $user, User $currentUser)
    {
        return UserFollow::where("follower_id", $currentUser->id)
            ->where("following_id", $user->id)
            ->delete();
    }
}
