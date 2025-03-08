<?php

namespace App\Http\Resources;

use App\Enums\NotificationType;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
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
            default => [
            ],
        };
    }

    public function newMessageNotification(): array
    {
        $data = $this->data["data"];
        $currentUser = User::find($data['current_user_id']);
        $message = Message::find($data['message_id']);
        return [
            'id' => $this->id,
            'type' => $this->type,
            'notifiable_id' => $this->notifiable_id,
            'notifiable_type' => $this->notifiable_type,
            'data' => [
                'user' => new UserResource($currentUser),
                'message' => new MessageResource($message),
                'title' => $data['title'],
            ],
            'read_at' => $this->read_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
