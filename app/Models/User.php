<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\HasFollow;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Scout\Searchable;
use Rappasoft\LaravelAuthenticationLog\Traits\AuthenticationLoggable;

final class User extends Authenticatable implements CanResetPassword, FilamentUser, MustVerifyEmail
{
    /** @use HasFactory<UserFactory> */
    use AuthenticationLoggable, HasFactory, HasFollow, Notifiable;

    use Searchable;

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

    /**
     * Get the user's messages.
     *
     * @return HasMany<Message>
     */
    public function messages(): HasMany
    {
        return $this->hasMany(Message::class, 'user_id');
    }

    public function favoriteMessages(): HasManyThrough
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
     * Get the indexable data array for the model.
     *
     * @return array<string, mixed>
     */
    public function toSearchableArray()
    {
        return array_merge($this->toArray(), [
            'id' => $this->getKey(), // this *must* be defined
        ]);
    }

    /**
     * Get the name of the index associated with the model.
     */
    public function searchableAs(): string
    {
        return 'users';
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
