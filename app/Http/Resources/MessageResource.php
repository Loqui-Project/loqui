<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user' => new UserResource($this->user),
            'sender' => $this->sender_id != null ? new UserResource($this->sender) : null,
            'message' => $this->message,
            'is_anon' => $this->is_anon,
            'likes_count' => $this->likes()->count(),
            'liked' => $this->likes()->where('user_id', $request->user()->id)->exists(),
            'replays_count' => $this->likes()->count(),
            'starred' => false,
            'replays' => MessageReplayResource::collection($this->replays()->latest()->get()),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
