<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MessageReplayResource extends JsonResource
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
            'message' => new MessageResource($this->message),
            'user' => new UserResource($this->user),
            'replay' => $this->replay,
            'image' => $this->mediaObject && new MediaObjectResource($this->mediaObject),
        ];
    }
}
