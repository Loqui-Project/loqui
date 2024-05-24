<?php

namespace App\Livewire\Layout;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\On;
use Livewire\Component;

class SidePanel extends Component
{
    public $users;

    public ?User $authUser = null;

    public string $type = 'following';

    public function mount()
    {
        $this->authUser = Auth::user();
        $this->users = $this->showUsers();
    }

    #[On('update-users')]
    public function updateUsers()
    {

    }

    #[On('showUsers')]
    public function showUsers($type = 'following')
    {
        $this->type = $type;
        $username = $this->authUser ? $this->authUser->username : request('username');
        $this->users = Cache::remember("users:{$this->authUser->id}:$type", 60, function () use ($username, $type) {
            return User::where('username', $username)->with(['mediaObject', "{$type}.mediaObject"])->first()->{$type};
        });

        return $this->users;
    }

    public function render()
    {
        return view('livewire.layout.side-panel', [
            'users' => $this->users,
            'type' => $this->type,
            'currentUser' => $this->authUser,
        ]);
    }
}
