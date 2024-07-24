<?php

namespace App\Livewire\Component\User;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class FollowSettingsDialog extends Component
{
    public User $user;

    public $authUser = null;

    public function mount(User $user)
    {
        $this->user = $user;
        $this->authUser = Auth::user();
    }

    public function render()
    {
        return view('livewire.component.user.follow-settings-dialog');
    }
}
