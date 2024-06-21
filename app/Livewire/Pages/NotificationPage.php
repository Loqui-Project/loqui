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

    public $notificationTypeEnum = "all";

    public int $perPage = 10;

    public function mount()
    {
        $this->authUser = Auth::user();
    }

    public function loadMore()
    {
        $this->perPage = $this->perPage + 10;
    }

    public function getListeners()
    {
        return [
            "echo-notification:user.{$this->authUser->id}" => "refresh",
        ];
    }

    public function refresh()
    {
        Cache::forget("user:{$this->authUser->id}:notifications");
    }

    #[Computed]
    public function notifications()
    {
        $key = "user:{$this->authUser->id}:messages:with_replay:{$this->perPage}";
        $seconds = now()->addHours(5); // 1 hour...

        return Cache::remember($key, $seconds, function () {
            return $this->authUser
                ->notifications()
                ->orderBy("created_at", "desc")
                ->paginate($this->perPage);
        });
    }

    public function render()
    {
        return view("livewire.pages.notification-page", [
            "notifications" => $this->notifications(),
        ])->extends("components.layouts.app");
    }
}
