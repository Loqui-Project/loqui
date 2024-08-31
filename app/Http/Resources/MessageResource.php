<?php

declare(strict_types=1);

namespace App\Http\Resources;

use AllowDynamicProperties;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

#[AllowDynamicProperties]
final class MessageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, Message>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'sender' => $this->sender === null ? null : new UserResource($this->sender),
            'user' => new UserResource($this->user),
            'url' => route('message.show', [
                'id' => $this->id,
            ]),
        ];
    }
}
