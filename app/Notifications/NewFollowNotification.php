<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Enums\NotificationType;
use App\Http\Resources\UserResource;
use App\Models\NotificationSetting;
use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection as SupportCollection;

final class NewFollowNotification extends Notification implements ShouldBroadcast, ShouldQueue
{
    use Dispatchable, InteractsWithSockets, Queueable, SerializesModels;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public User $user,
        public User $currentUser,
    ) {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {

        // Check what user wants to be notified about
        $via = ['database'];

        /** @var SupportCollection<string, NotificationSetting> $notificationSettings */
        $notificationSettings = collect(NotificationSetting::where('user_id', $this->user->id)->where('type', NotificationType::NEW_FOLLOWER->value)->get())->groupBy('key');

        /** @var bool $browserNotification */
        $browserNotification = $notificationSettings->get('browser', fn () => $this->user->notificationSettings->where('key', 'browser')->first()?->value);

        /** @var bool $emailNotification */
        $emailNotification = optional($notificationSettings->get('email'), fn () => $this->user->notificationSettings->where('key', 'email')->first()?->value);

        if ($browserNotification === true) {
            $via[] = 'broadcast';
        }
        if ($emailNotification === true) {
            $via[] = 'mail';
        }

        return $via;
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage())
            ->subject('New Follower')
            ->line("{$this->currentUser->name} followed you.")
            ->action('View Profile', route('profile', $this->currentUser));
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [new PrivateChannel("user.{$this->user->id}")];
    }

    /**
     * Get the data to broadcast.
     *
     * @return array<string, mixed>
     */
    public function broadcastWith(): array
    {

        return [
            'type' => NotificationType::NEW_FOLLOWER->value,
            'user' => new UserResource($this->user),
            'currentUser' => new UserResource($this->currentUser),
            'title' => "{$this->currentUser->name} followed you.",
            'url' => route('profile', $this->currentUser),
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {

        return [
            'current_user_id' => $this->currentUser->id,
            'title' => "{$this->currentUser->name} followed you.",
            'url' => route('profile', $this->currentUser),
        ];
    }

    /**
     * Get the notification's database type.
     */
    public function databaseType(object $notifiable): string
    {
        return NotificationType::NEW_FOLLOWER->value;
    }

    /**
     * Get the type of the notification being broadcast.
     */
    public function broadcastType(): string
    {
        return NotificationType::NEW_FOLLOWER->value;
    }
}
