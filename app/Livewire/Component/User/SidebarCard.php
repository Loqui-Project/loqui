<?php

namespace App\Livewire\Component\User;

use App\Jobs\NewFollowerJob;
use App\Livewire\Layout\SidePanel;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class SidebarCard extends Component
{
    public User $user;

    public ?User $authUser = null;

    public string $type;

    public bool $isContains = false;

    public function mount(User $user, string $type, ?User $authUser = null)
    {
        $this->user = $user;
        $this->type = $type;
        $this->authUser = $authUser;
        if ($this->authUser === null) {
            $this->isContains = false;
        } else {
            $this->isContains = $this->authUser->isFollowing($user);
        }
    }

    public function follow($id)
    {
        $user = User::find($id);
        if ($this->isContains) {
            $this->authUser->unfollowUser($user, $this->authUser);
            $this->isContains = false;
        } else {
            $this->authUser->followUser($user, $this->authUser);
            $this->isContains = true;
            NewFollowerJob::dispatch($user, $this->authUser);
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
