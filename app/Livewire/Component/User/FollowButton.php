<?php

namespace App\Livewire\Component\User;

use App\Jobs\NewFollowerJob;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class FollowButton extends Component
{
    public ?User $user;

    public $isModalOpen = false;

    public ?User $authUser = null;

    public bool $isFollowing = false;

    public function mount(User $user)
    {
        $this->user = $user;
        $this->authUser = Auth::user();
        if ($this->authUser) {
            $this->isFollowing = $this->authUser->isFollowing($this->user);
        } else {
            $this->isFollowing = false;
        }
    }

    public function openFollowingSettings()
    {
        $this->isModalOpen = true;

    }

    public function follow()
    {
        if (! $this->authUser) {
            $this->dispatch('not-auth-for-follow');

            return;
        }

        $this->authUser->followUser($this->user, $this->authUser);
        NewFollowerJob::dispatch($this->user, $this->authUser);
        $this->isFollowing = true;
    }

    public function unfollow()
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
