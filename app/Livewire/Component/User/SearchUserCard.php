<?php

declare(strict_types=1);

namespace App\Livewire\Component\User;

use App\Livewire\Layout\SidePanel;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

final class SearchUserCard extends Component
{
    public User $user;

    public ?User $authUser = null;

    public bool $isFollowing = false;

    public function mount(User $user): void
    {
        $this->user = $user;

        $this->authUser = Auth::user();
        $this->isFollowing = $this->authUser->isFollowing($user);
    }

    public function follow($id): void
    {
        $user = User::find($id);
        if ($this->isFollowing) {
            $this->authUser->unfollowUser($user, $this->authUser);
            $this->isFollowing = false;
        } else {
            $this->authUser->followUser($user, $this->authUser);
            $this->isFollowing = true;
        }
        $this->user = $user;
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
