<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Enums\NotificationType;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Notifications\DatabaseNotification as Notification;

/**
 * @mixin Notification
 */
final class NotificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return match ($this->type) {
            NotificationType::NEW_MESSAGE->value => $this->newMessageNotification(),
            NotificationType::NEW_FOLLOWER->value => $this->newFollowerNotification(),

            default => [
            ],
        };
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function newMessageNotification(): array
    {
        $data = $this->data;
        $currentUser = User::find($data['current_user_id']);
        $message = Message::find($data['message_id']);

        return [
            'id' => $this->id,
            'type' => $this->type,
            'data' => [
                'user' => $currentUser ? new UserResource($currentUser) : [
                    'id' => null,
                    'username' => 'anonymous',
                    'name' => 'Anonymous',
                    'image_url' => '/images/default-avatar.png',
                    'email_verified_at' => null,
                    'is_following' => false,
                ],
                'message' => new MessageResource($message),
                'title' => $data['title'],
                'url' => $data['url'],

            ],
            'read_at' => $this->read_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function newFollowerNotification(): array
    {
        $data = $this->data;
        $currentUser = User::find($data['current_user_id']);

        return [
            'id' => $this->id,
            'type' => $this->type,
            'notifiable_id' => $this->notifiable_id,
            'notifiable_type' => $this->notifiable_type,
            'data' => [
                'user' => new UserResource($currentUser),
                'title' => $data['title'],
                'url' => $data['url'],
            ],
            'read_at' => $this->read_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
