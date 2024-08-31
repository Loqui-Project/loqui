<?php

declare(strict_types=1);

namespace App\Livewire\Component\User;

use App\Livewire\Layout\SidePanel;
use App\Models\User;
use Livewire\Component;

final class SidebarCard extends Component
{
    public User $user;

    public ?User $authUser = null;

    public string $type;

    public bool $isContains = false;

    public function mount(User $user, string $type, ?User $authUser = null): void
    {
        $this->user = $user;
        $this->type = $type;
        $this->authUser = $authUser;
        $this->isContains = $this->authUser instanceof User ? $this->authUser->isFollowing($user) : false;
    }

    public function follow($id): void
    {
        $user = User::find($id);
        if ($this->isContains) {
            $this->authUser->unfollowUser($user, $this->authUser);
            $this->isContains = false;
        } else {
            $this->authUser->followUser($user, $this->authUser);
            $this->isContains = true;
        }
        $this->user = $user;
        $this->dispatch('update-users')->to(SidePanel::class);
    }

    public function render()
    {
        return view('livewire.component.user.sidebar-card', [
            'user' => $this->user,
            'isContains' => $this->isContains,
        ]);
    }
}
