<?php

declare(strict_types=1);

namespace App\Livewire\Component\Notification;

use App\Models\User;
use App\NotificationTypeEnum;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Livewire\Component;

final class DropDown extends Component
{
    public Collection $notifications;

    public ?User $user = null;

    public $count = 0;

    public array $notification_type = [];

    public string $activeTab = 'all';

    public function mount(): void
    {
        $this->user = Auth::user();

        $notifications = $this->user->notifications();
        $this->notifications = $notifications
            ->when($this->activeTab !== 'all', fn ($query) => $query->where('type', "$this->activeTab"))
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        $this->count = $this->user->unreadNotifications()->count();
        $this->notification_type = array_map(fn ($key): array => [
            'key' => $key,
            'name' => __(key: $key),
        ], NotificationTypeEnum::values());
    }

    public function getListeners()
    {
        return [
            "echo-notification:user.{$this->user->id}" => 'refresh',
        ];
    }

    public function makeAllRead(): void
    {
        $this->user->notifications()->where('read_at', null)->update([
            'read_at' => Date::now(),
        ]);
        $this->refresh();
    }

    public function setActiveTab(string $tab): void
    {
        $this->activeTab = $tab;
        $this->refresh();
    }

    public function refresh(): void
    {
        $this->notifications = $this->user
            ->notifications()
            ->when($this->activeTab !== 'all', fn ($query) => $query->where('type', "$this->activeTab"))
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
