<?php

declare(strict_types=1);

namespace App\Livewire\Component\User;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

final class FollowSettingsDialog extends Component
{
    public User $user;

    public $authUser;

    public function mount(User $user): void
    {
        $this->user = $user;
        $this->authUser = Auth::user();
    }

    public function render()
    {
        return view('livewire.component.user.follow-settings-dialog');
    }
}
