<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public static $wrap = null;

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
            'profile_image' => $this->mediaObject ? new MediaObjectResource($this->mediaObject) : null,
            'name' => $this->name,
            'email' => $this->email,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'following' => $this->following->count(),
            'followers' => $this->follower->count(),
            'messages' => $this->messages->count(),
            'is_following' => $this->follower->contains($request->user()),
            'mutual_friends' => $this->whenLoaded('follower', function () use ($request) {
                $mutual_friends = collect($this->follower->intersect($request->user()->follower))->map(function ($user) {
                    return [
                        'id' => $user->id,
                        'name' => $user->name,
                        'username' => $user->username,
                        'profile_image' => $user->mediaObject ? new MediaObjectResource($user->mediaObject) : null,
                    ];
                });

                return $mutual_friends;
            }),
        ];
    }
}
