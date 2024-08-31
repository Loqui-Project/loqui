<?php

declare(strict_types=1);

namespace App\Livewire\Layout;

use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Component;

final class SidePanel extends Component
{
    public $users;

    public ?User $authUser = null;

    public string $type = 'following';

    public function mount(User $user): void
    {
        $this->authUser = $user;
        $this->users = $this->showUsers();
    }

    #[On('update-users')]
    public function updateUsers(): void {}

    #[On('showUsers')]
    public function showUsers(string $type = 'following')
    {
        $this->type = $type;
        $requestUsername = request('username');
        $authUsername = $this->authUser->username;
        $isSameAuth = false;
        if ($authUsername === $requestUsername || ! $requestUsername) {
            $username = $authUsername;
            $isSameAuth = true;
        } else {
            $username = $requestUsername;
        }

        $this->users = $isSameAuth ? $this->authUser->{$type} : User::where('username', $username)
            ->first()->{$type};

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
