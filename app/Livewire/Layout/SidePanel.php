<?php

namespace App\Livewire\Layout;

use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\On;
use Livewire\Component;

class SidePanel extends Component
{
    public $users;

    public ?User $authUser = null;

    public string $type = 'following';

    public function mount(User $user)
    {
        $this->authUser = $user;
        $this->users = $this->showUsers();
    }

    #[On('update-users')]
    public function updateUsers() {}

    #[On('showUsers')]
    public function showUsers($type = 'following')
    {
        $this->type = $type;
        $requestUsername = request('username');
        $authUsername = $this->authUser->username;
        $isSameAuth = false;
        if ($authUsername == $requestUsername || ! $requestUsername) {
            $username = $authUsername;
            $isSameAuth = true;
        } else {
            $username = $requestUsername;
        }

        if ($isSameAuth) {
            $this->users = Cache::remember(
                "users:{$username}:{$type}",
                60,
                function () use ($type) {
                    $this->authUser->{$type};
                },
            );
        } else {
            $this->users = Cache::remember(
                "users:{$username}:{$type}",
                60,
                function () use ($username, $type) {
                    return User::where('username', $username)
                        ->with(['mediaObject', "{$type}.mediaObject"])
                        ->first()->{$type};
                },
            );
        }

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
