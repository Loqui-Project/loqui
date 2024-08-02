<?php

namespace App\Livewire\Component\User;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class HomeCard extends Component
{
    protected $shareData = [];

    public User $user;

    public Collection $users;

    public array $user_data;

    public function mount(User $user, array $userData)
    {
        $this->user = $user;
        $this->user_data = $userData;
        $this->users = $this->getUsersByType();
    }

    public function getUsersByType($type = 'following'): Collection
    {
        return $this->user->{$type};
    }

    public function activeTab($type = 'following')
    {
        $this->users = $this->getUsersByType($type);
    }

    public function render()
    {
        $this->shareData['url'] = route('profile.user', [
            'user' => $this->user->username,
        ]);
        $this->shareData['title'] = $this->user->name;

        return view('livewire.component.user.home-card', [
            'user' => $this->user,
            'followingCount' => $this->user_data['following']['count'],
            'followersCount' => $this->user_data['followers']['count'],
            'messagesCount' => $this->user_data['messages'],
            'share_data' => $this->shareData,
            'users' => $this->users,
        ]);
    }
}
