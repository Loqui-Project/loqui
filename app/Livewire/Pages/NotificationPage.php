<?php

declare(strict_types=1);

namespace App\Livewire\Pages;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

final class NotificationPage extends Component
{
    use WithoutUrlPagination, WithPagination;

    public User $authUser;

    public $notificationTypeEnum = 'all';

    public int $perPage = 10;

    public function mount(): void
    {
        $this->authUser = Auth::user();
    }

    public function loadMore(): void
    {
        $this->perPage += 10;
    }

    public function getListeners()
    {
        return [
            "echo-notification:user.{$this->authUser->id}" => 'refresh',
        ];
    }

    public function refresh(): void
    {
        Cache::forget("user:{$this->authUser->id}:notifications");
    }

    #[Computed]
    public function notifications()
    {
        $key = "user:{$this->authUser->id}:messages:with_replay:{$this->perPage}";
        $seconds = now()->addHours(5); // 1 hour...

        return Cache::remember($key, $seconds, fn () => $this->authUser
            ->notifications()
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage));
    }

    #[Layout('components.layouts.app')]
    #[Title('Notifications')]
    public function render()
    {
        return view('livewire.pages.notification-page', [
            'notifications' => $this->notifications(),
        ]);
    }
}
