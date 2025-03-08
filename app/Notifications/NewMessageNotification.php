<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Enums\NotificationType;
use App\Models\Message;
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

final class NewMessageNotification extends Notification implements ShouldBroadcast, ShouldQueue
{
    use Dispatchable, InteractsWithSockets, Queueable, SerializesModels;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public User $user,
        public ?User $currentUser,
        public Message $message,
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
        return ['database', 'broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->greeting("Hello {$this->user->name}!")
            ->line("You have a new message from {$this->currentUser->name}.");
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

        $title = $this->currentUser ? "{$this->currentUser->name} send you a new message." : 'Anonymous send you a new message.';

        return [
            'type' => NotificationType::NEW_MESSAGE->value,
            'user' => $this->user->toArray(),
            'currentUser' => $this->currentUser ? $this->currentUser->toArray() : [
                'id' => null,
                'name' => 'Anonymous',
            ],
            'message' => $this->message->toArray(),
            'title' => $title,
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $title = $this->currentUser ? "{$this->currentUser->name} send you a new message." : 'Anonymous send you a new message.';

        return [
            'current_user_id' => $this->currentUser?->id,
            'message_id' => $this->message->id,
            'title' => $title,
            'url' => route('message.show', $this->message),
        ];
    }

    /**
     * Get the notification's database type.
     */
    public function databaseType(object $notifiable): string
    {
        return NotificationType::NEW_MESSAGE->value;
    }

    /**
     * Get the type of the notification being broadcast.
     */
    public function broadcastType(): string
    {
        return NotificationType::NEW_MESSAGE->value;
    }
}
