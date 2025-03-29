<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

/**
 * @mixin User
 */
final class UserResource extends JsonResource
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
            'bio' => $this->bio,
            'image_url' => $this->image_url ? asset('storage/'.$this->image_url) : '/images/default-avatar.png',
            'email_verified_at' => $this->email_verified_at,
            'is_following_me' => $this->following()->where('user_id', Auth::id())->exists(),
            'is_following' => $this->followers()->where('follower_id', Auth::id())->exists(),
        ];
    }
}
