<?php

namespace App\Livewire\Component\User;

use App\Jobs\NewFollowerJob;
use App\Livewire\Layout\SidePanel;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class SearchUserCard extends Component
{
    public User $user;

    public ?Authenticatable $currentUser = null;

    public bool $isFollowing = false;

    public function mount(User $user)
    {
        $this->user = $user;
        $this->currentUser = Auth::user();
        if ($this->currentUser === null) {
            $this->isFollowing = false;
        } else {
            $this->isFollowing = $this->currentUser->isFollowing($user);
        }
    }

    public function follow($id)
    {
        $user = User::find($id);
        if ($this->isFollowing) {
            $this->currentUser->unfollowUser($user, $this->currentUser);
            $this->isFollowing = false;
        } else {
            $this->currentUser->followUser($user, $this->currentUser);
            $this->isFollowing = true;
            NewFollowerJob::dispatch($user, $this->currentUser);
        }
        $this->user = $user;
        Cache::forget('users:following');
        $this->dispatch('update-users')->to(SidePanel::class);
    }

    public function render()
    {
        return view('livewire.component.user.search-user-card', [
            'user' => $this->user,
            'isFollowing' => $this->isFollowing,
        ]);
    }
}
