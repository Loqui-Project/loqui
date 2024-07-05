<?php

namespace App\Notifications;

use App\Http\Resources\MessageResource;
use App\Http\Resources\UserResource;
use App\Models\Message;
use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Queue\SerializesModels;

class NewReplayNotification extends Notification  implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, Queueable, SerializesModels;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public User $user,
        public User $currentUser,
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
        $viaArray = [];
        $userNotificationSettings = $this->user->notificationSettings();
        $browser = $userNotificationSettings
            ->where('type', 'browser')
            ->get()
            ->pluck('key')
            ->toArray();
        $mail = $userNotificationSettings
            ->where('type', 'mail')
            ->get()
            ->pluck('key')
            ->toArray();
        if ($browser && in_array('replay', $browser)) {
            $viaArray[] = 'broadcast';
            $viaArray[] = 'database';
        }
        if ($mail && in_array('replay', $mail)) {
            $viaArray[] = 'mail';
        }

        return $viaArray;
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->greeting("Hello {$this->user->name}!")
            ->line("You have a new message from {$this->currentUser->name}.")
            ->action(
                'View message',
                route('message.show', [
                    'id' => $this->message->id,
                ]),
            );
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
            'type' => 'new-replay',
            'user' => new UserResource($this->user),
            'currentUser' => new UserResource($this->currentUser),
            'message' => new MessageResource($this->message),
            'url' => route('message.show', [
                'id' => $this->message->id,
            ]),
            'title' => "{$this->currentUser->name} add new replay on your message.",
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
            'message_id' => $this->message->id,
            'title' => "{$this->currentUser->name} add new replay on your message.",
        ];
    }

    /**
     * Get the notification's database type.
     */
    public function databaseType(object $notifiable): string
    {
        return 'new-replay';
    }

    /**
     * Get the type of the notification being broadcast.
     */
    public function broadcastType(): string
    {
        return 'new-replay';
    }
}
