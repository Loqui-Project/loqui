<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
{
    public static $wrap = null;

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // check if the message is newest or not
        $is_newest = $this->created_at == $this->user->messages->last()->created_at;

        return [
            'id' => $this->id,
            'sender' => new UserResource($this->sender),
            'user' => new UserResource($this->user),
            'message' => $this->message,
            'is_anon' => $this->is_anon,
            'replay' => $this->whenLoaded('replay', function () {
                return new MessageReplayResource($this->replay->first());
            }),
            'created_at' => Carbon::parse($this->created_at)->format('D-M-Y'),
            'is_new' => $is_newest,
            'likes' => $this->likes->count(),
            'liked' => $this->likes->contains('user_id', $request->user()->id),
            'favorites' => $this->favorites->count(),
            'favorited' => $this->favorites->contains('user_id', $request->user()->id),

        ];
    }
}
