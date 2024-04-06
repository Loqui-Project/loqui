<?php

namespace App\Livewire\Pages;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class NotificationPage extends Component
{
    public User $authUser;

    public Collection $notifications;

    public $notificationTypeEnum = 'all';

    public function mount()
    {

        $this->authUser = Auth::user();
        $this->notifications = Cache::remember("user:{$this->authUser->id}:notifications", 60 * 60 * 24 * 1, function () {
            return $this->authUser->notifications()->latest()->get();
        });
    }

    public function render()
    {
        return view('livewire.pages.notification-page', [
            'notifications' => $this->notifications,
        ])->extends('components.layouts.app');
    }
}
