<?php

namespace App\Models;

use App\Contracts\FollowUserInterface;
use App\Traits\HasFollow;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements CanResetPassword, FollowUserInterface, MustVerifyEmail, FilamentUser
{
    use HasFactory, HasFollow, Notifiable, Cachable;
    protected $cachePrefix = "user:";

    protected $cacheCooldownSeconds = 3600 * 6;

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
    protected $hidden = ['password', 'remember_token'];

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
        return $this->hasManyThrough(
            Message::class,
            MessageFavourite::class,
            'user_id',
            'id',
            'id',
            'message_id',
        );
    }

    public function likedMessages()
    {
        return $this->belongsToMany(
            Message::class,
            'liked_messages',
            'user_id',
            'message_id',
        );
    }

    public function notificationSettings(): HasMany
    {
        return $this->hasMany(NotificationSettings::class, 'user_id');
    }

    public function receivesBroadcastNotificationsOn(): string
    {
        return "user.{$this->id}";
    }

    public function getRouteKeyName(): string
    {
        return 'username';
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return str_ends_with($this->email, '@yanalshoubaki.com');
    }
}
