<?php

namespace App\Livewire\Component\User;

use App\Jobs\NewFollowerJob;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class SearchUserCard extends Component
{
    public User $user;

    public ?Authenticatable $authUser = null;

    public bool $isFollowing = false;

    public function mount(User $user)
    {
        $this->user = $user;
        $this->authUser = Auth::user();
        $this->isFollowing = $this->authUser->isFollowing($user);
    }

    public function follow($id)
    {
        $user = User::find($id);
        if ($this->isFollowing) {
            $this->authUser->unfollowUser($user, $this->authUser);
            $this->isFollowing = false;
        } else {
            $this->authUser->followUser($user, $this->authUser);
            $this->isFollowing = true;
            NewFollowerJob::dispatch($user, $this->authUser);
        }
        $this->user = $user;
    }

    public function render()
    {
        return view('livewire.component.user.search-user-card', [
            'user' => $this->user,
            'isFollowing' => $this->isFollowing,
        ]);
    }
}
