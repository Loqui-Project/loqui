<?php

namespace App\Livewire\Component\Notification;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class DropDown extends Component
{
    public Collection $notifications;

    public ?User $user = null;

    public $count = 0;

    public function mount()
    {
        $this->user = Auth::user();

        $notifications = $this->user->notifications();
        $this->notifications = $notifications
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        $this->count = $this->user->unreadNotifications()->count();
    }

    public function getListeners()
    {
        return [
            "echo-notification:user.{$this->user->id}" => 'refresh',
        ];
    }

    public function refresh()
    {
        $this->notifications = $this->user
            ->notifications()
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        $this->count = $this->user->unreadNotifications()->count();
    }

    public function render()
    {
        return view('livewire.component.notification.drop-down', [
            'notifications' => $this->notifications,
            'count' => $this->count,
        ]);
    }
}
