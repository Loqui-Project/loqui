<?php

namespace App\Notifications;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Queue\SerializesModels;

class NewFollowerNotification extends Notification implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, Queueable, SerializesModels;

    /**
     * Create a new notification instance.
     */
    public function __construct(public User $user, public User $currentUser)
    {
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
            ->where("type", "browser")

            ->get()
            ->pluck("key")
            ->toArray();
        $mail = $userNotificationSettings
            ->where("type", "mail")
            ->get()
            ->pluck("key")
            ->toArray();
        if ($browser && in_array("follow", $browser)) {
            $viaArray[] = "broadcast";
            $viaArray[] = "database";
        }
        if ($mail && in_array("follow", $mail)) {
            $viaArray[] = "mail";
        }

        return $viaArray;
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage())
            ->greeting("Hello {$this->user->name}!")
            ->line("You have a new follower.")
            ->line("{$this->currentUser->name} started following you.")
            ->action(
                "View his profile",
                route("profile.user", [
                    "user" => $this->currentUser->username,
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
            "user" => new UserResource($this->user),
            "currentUser" => new UserResource($this->currentUser),
            "url" => route("profile.user", $this->currentUser->username),
            "title" => "{$this->currentUser->name} started following you.",
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
            "current_user_id" => $this->currentUser->id,
            "title" => "{$this->currentUser->name} started following you.",
        ];
    }

    /**
     * Get the notification's database type.
     */
    public function databaseType(object $notifiable): string
    {
        return "new-follow";
    }

    /**
     * Get the type of the notification being broadcast.
     */
    public function broadcastType(): string
    {
        return "new-follow";
    }
}
