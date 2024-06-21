<?php

namespace App\Livewire\Component\User;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Computed;
use Livewire\Component;

class HomeCard extends Component
{
    protected $shareData = [];

    public User $user;

    public Collection $users;

    public function mount(User $user)
    {
        $this->user = $user;
        $this->users = $this->getUsersByType();
    }

    #[Computed]
    public function getUsersByType($type = "following"): Collection
    {
        return Cache::remember(
            "user:{$this->user->id}:{$type}",
            3600 * 6,
            function () use ($type) {
                return $this->user->{$type}()->get();
            },
        );
    }

    #[Computed]
    public function getFollowersCountProperty(): int
    {
        return Cache::remember(
            "user:{$this->user->id}:followers_count",
            3600 * 6,
            function () {
                return $this->user->followers()->count();
            },
        );
    }

    #[Computed]
    public function getMessagesCountProperty(): int
    {
        return Cache::remember(
            "user:{$this->user->id}:messages_count",
            3600 * 6,
            function () {
                return $this->user->messages()->whereHas("replay")->count();
            },
        );
    }

    #[Computed]
    public function getFollowingCountProperty(): int
    {
        return Cache::remember(
            "user:{$this->user->id}:following_count",
            3600 * 6,
            function () {
                return $this->user->following()->count();
            },
        );
    }

    public function activeTab($type = "following")
    {
        $this->users = $this->getUsersByType($type);
    }

    public function render()
    {
        $this->shareData["url"] = route("profile.user", [
            "user" => $this->user->username,
        ]);
        $this->shareData["title"] = $this->user->name;

        return view("livewire.component.user.home-card", [
            "user" => $this->user,
            "followersCount" => $this->getFollowersCountProperty(),
            "followingCount" => $this->getFollowingCountProperty(),
            "messagesCount" => $this->getMessagesCountProperty(),
            "share_data" => $this->shareData,
            "users" => $this->users,
        ]);
    }
}
