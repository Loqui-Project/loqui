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

    public string $type = 'following';

    public function mount()
    {
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
        $username = Auth::check() ? Auth::user()->username : request('username');
        $this->users = Cache::remember("users:$type", 60, function () use ($username, $type) {
            return User::where('username', $username)->first()->{$type};
        });

        return $this->users;
    }

    public function render()
    {
        return view('livewire.layout.side-panel', [
            'users' => $this->users,
            'type' => $this->type,
        ]);
    }
}
