<?php

declare(strict_types=1);

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
use Rappasoft\LaravelAuthenticationLog\Traits\AuthenticationLoggable;

final class User extends Authenticatable implements CanResetPassword, FilamentUser, FollowUserInterface, MustVerifyEmail
{
    /** @use HasFactory<UserFactory> */
    use AuthenticationLoggable, Cachable, HasFactory, HasFollow, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'image_url',
        'email',
        'status',
        'password',
        'bio',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = ['password', 'remember_token'];

    private string $cachePrefix = 'user:';

    private int $cacheCooldownSeconds = 3600 * 6;

    /**
     * Get the user's messages.
     *
     * @return HasMany<Message>
     */
    public function messages(): HasMany
    {
        return $this->hasMany(Message::class, 'user_id');
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

    /**
     * Get the user's notification settings.
     *
     * @return HasMany<NotificationSettings>
     */
    public function notificationSettings(): HasMany
    {
        return $this->hasMany(NotificationSettings::class, 'user_id');
    }

    public function receivesBroadcastNotificationsOn(): string
    {
        return "user.{$this->id}";
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return str_ends_with($this->email, '@yanalshoubaki.com');
    }

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
}
