<?php

namespace App\Livewire\Component\Notification;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class DropDown extends Component
{


    public Collection $notifications;

    public ?User $user = null;

    public $count = 0;

    public function mount()
    {
        $this->user = Auth::user();
        Cache::driver("redis")->remember("notifications.{$this->user->id}", 60 * 60 * 60, function () {
            $notifications = $this->user->notifications()->with(["user"]);
            $this->notifications = $notifications->orderBy('created_at', 'desc')->limit(5)->get();
            $this->count = $this->notifications->filter(fn ($notification) => $notification->unread())->count();
        });
    }

    public function getListeners()
    {
        return [
            "echo-private:App.Models.User.{$this->user->id},NewMessageEvent" => 'refresh',
        ];
    }

    public function refresh()
    {
        Cache::driver("redis")->forget("notifications.{$this->user->id}");
    }

    public function render()
    {
        return view('livewire.component.notification.drop-down', [
            'notifications' => $this->notifications,
            'count' => $this->count,
        ]);
    }
}
