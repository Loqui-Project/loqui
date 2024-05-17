<?php

namespace App\Livewire\Component\User;

use App\Jobs\NewFollowerJob;
use App\Livewire\Layout\SidePanel;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Livewire\Component;

class SidebarCard extends Component
{
    public User $user;

    public ?Authenticatable $currentUser = null;

    public string $type;

    public bool $isContains = false;

    public function mount(User $user, string $type)
    {
        $this->user = $user;
        $this->type = $type;
        $this->currentUser = Auth::user();
        $this->isContains = $this->currentUser->isFollowing($user);
    }

    public function follow($id)
    {
        $user = User::find($id);
        $column_id = Str::singular($this->type).'_id';
        if ($this->isContains) {
            $this->currentUser->unfollowUser($user, $this->currentUser);
            $this->isContains = false;
        } else {
            $this->currentUser->followUser($user, $this->currentUser);
            $this->isContains = true;
            NewFollowerJob::dispatch($user, $this->currentUser);
        }
        $this->user = $user;
        Cache::forget("users:$this->type");
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
