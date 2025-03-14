<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'username' => $this->username,
            'name' => $this->name,
            'email' => $this->email,
            'image_url' => $this->image_url ? asset('storage/'.$this->image_url) : '/images/default-avatar.png',
            'is_following' => $this->followers->contains('id', $request->user()->id),
        ];
    }
}
