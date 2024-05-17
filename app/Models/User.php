<?php

namespace App\Models;

use App\Contracts\FollowUserInterface;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements CanResetPassword, FollowUserInterface, MustVerifyEmail
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'media_object_id',
        'email',
        'status',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function following(): HasManyThrough
    {
        return $this->hasManyThrough(User::class, UserFollow::class, 'follower_id', 'id', 'id', 'following_id');
    }

    public function followers(): HasManyThrough
    {
        return $this->hasManyThrough(User::class, UserFollow::class, 'following_id', 'id', 'id', 'follower_id');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class, 'user_id');
    }

    public function mediaObject()
    {
        return $this->belongsTo(MediaObject::class, 'media_object_id', 'id');
    }

    public function favoriteMessages()
    {
        return $this->belongsToMany(Message::class, 'favorite_messages', 'user_id', 'message_id');
    }

    public function likedMessages()
    {
        return $this->belongsToMany(Message::class, 'liked_messages', 'user_id', 'message_id');
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class, 'user_id');
    }

    public function isFollowing(User $user)
    {
        return $this->following()->where('following_id', $user->id)->exists();
    }

    public function followUser(User $user, User $currentUser)
    {
        if (! $this->isFollowing($user)) {
            UserFollow::create([
                'follower_id' => $currentUser->id,
                'following_id' => $user->id,
            ]);
        }
    }

    public function unfollowUser(User $user, User $currentUser)
    {
        return UserFollow::where('follower_id', $currentUser->id)->where('following_id', $user->id)->delete();
    }
}
