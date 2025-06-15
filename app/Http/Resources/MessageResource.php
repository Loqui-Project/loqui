<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\URL;

/**
 * @mixin Message
 */
final class MessageResource extends JsonResource
{
    public static $wrap;

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
            'sender' => $this->sender_id !== null || $this->is_anon ? new UserResource($this->sender) : null,
            'message' => $this->message,
            'likes_count' => $this->likes_count,
            'liked' => collect(($this->likes))->contains('user_id', $request->user()?->id),
            'replays_count' => $this->replays_count,
            'replays' => MessageReplayResource::collection($this->whenLoaded('replays')),
            'image_url' => $this->image_url ? URL::asset('storage/'.$this->image_url) : null,
            'is_anon' => $this->is_anon,
            'is_favorite' => collect($this->favorites)->contains('user_id', $request->user()?->id),
            'created_at' => $this->created_at,
        ];
    }
}
