<?php

declare(strict_types=1);

namespace App\Livewire\Component\User;

use App\Jobs\NewFollowerJob;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

final class FollowButton extends Component
{
    public ?User $user = null;

    public $isModalOpen = false;

    public ?User $authUser = null;

    public bool $isFollowing = false;

    public function mount(User $user): void
    {
        $this->user = $user;
        $this->authUser = Auth::user();
        $this->isFollowing = $this->authUser ? $this->authUser->isFollowing($this->user) : false;
    }

    public function openFollowingSettings(): void
    {
        $this->isModalOpen = true;

    }

    public function follow(): void
    {
        if (! $this->authUser instanceof User) {
            $this->dispatch('not-auth-for-follow');

            return;
        }

        $this->authUser->followUser($this->user, $this->authUser);
        NewFollowerJob::dispatch($this->user, $this->authUser);
        $this->isFollowing = true;
    }

    public function unfollow(): void
    {
        $this->authUser->unfollowUser($this->user, $this->authUser);
        $this->isFollowing = false;
        $this->isModalOpen = false;
    }

    public function render()
    {
        return view('livewire.component.user.follow-button');
    }
}
