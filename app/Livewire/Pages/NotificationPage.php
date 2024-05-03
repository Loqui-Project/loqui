<?php

namespace App\Livewire\Pages;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class NotificationPage extends Component
{
    use WithoutUrlPagination, WithPagination;

    public User $authUser;

    public $notificationTypeEnum = 'all';

    public int $perPage = 5;

    public function mount()
    {
        $this->authUser = Auth::user();
    }

    public function loadMore()
    {
        $this->perPage = $this->perPage + 5;
    }

    #[Computed()]
    public function notifications()
    {
        $key = "user:{$this->authUser->id}:notifications";
        $seconds = 3600 * 6;

        return Cache::remember(
            $key,
            $seconds,
            function () {
                return $this->authUser->notifications()
                    ->orderBy('created_at', 'desc')
                    ->paginate($this->perPage);
            }
        );
    }

    public function render()
    {
        return view('livewire.pages.notification-page', [
            'notifications' => $this->notifications(),
        ])->extends('components.layouts.app');
    }
}
