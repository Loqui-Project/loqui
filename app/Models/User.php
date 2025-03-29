<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\UserStatusEnum;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Laravel\Scout\Searchable;
use Spatie\Permission\Traits\HasRoles;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $username
 * @property string $image_url
 * @property UserStatusEnum $status
 * @property string $bio
 * @property ?Carbon $email_verified_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property-read Message[] $messages
 * @property-read UserSocialAuth[] $socialConnections
 * @property-read Collection<int, User> $following
 * @property-read Collection<int, User> $followers
 * @property-read MessageFavourite[] $favouriteMessages
 */
final class User extends Authenticatable implements FilamentUser, MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    use HasRoles;
    use Searchable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'username',
        'image_url',
        'status',
        'bio',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->hasRole('super-admin');
    }

    /**
     * Get the user's messages.
     *
     * @return HasMany<Message, covariant $this>
     */
    public function messages(): HasMany
    {
        return $this->hasMany(Message::class, 'user_id');
    }

    /**
     * Get the user's social connections.
     *
     * @return HasMany<UserSocialAuth, covariant $this>
     */
    public function socialConnections(): HasMany
    {
        return $this->hasMany(UserSocialAuth::class, 'user_id');
    }

    /**
     * Get the user's followers.
     *
     * @return BelongsToMany<User, covariant $this>
     */
    public function followers(): BelongsToMany
    {
        return $this->belongsToMany(self::class, 'user_follows', 'user_id', 'follower_id');
    }

    /**
     * Get the user's following.
     *
     * @return BelongsToMany<User, covariant $this>
     */
    public function following(): BelongsToMany
    {
        return $this->belongsToMany(self::class, 'user_follows', 'follower_id', 'user_id');
    }

    /**
     * Get the user's favourite messages.
     *
     * @return HasMany<MessageFavourite, covariant $this>
     */
    public function favouriteMessages(): HasMany
    {
        return $this->hasMany(MessageFavourite::class, 'user_id');
    }

    /**
     * Check if the user has favourited a message.
     *
     * @return HasMany<Session, covariant $this>
     */
    public function sessions(): HasMany
    {
        return $this->hasMany(Session::class, 'user_id');
    }

    /**
     * Get the user's notification settings.
     *
     * @return HasMany<NotificationSetting, covariant $this>
     */
    public function notificationSettings(): HasMany
    {
        return $this->hasMany(NotificationSetting::class, 'user_id');
    }

    /**
     * Get the value used to index the model.
     */
    public function getScoutKey(): mixed
    {
        return $this->id;
    }

    /**
     * Get the key name used to index the model.
     */
    public function getScoutKeyName(): mixed
    {
        return 'id';
    }

    /**
     * Get the indexable data array for the model.
     *
     * @return array<mixed>
     */
    public function toSearchableArray(): array
    {

        return $this->toArray();
    }

    public function deactivate(): void
    {
        $this->status = UserStatusEnum::DEACTIVATED;
        $this->save();
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
            'status' => UserStatusEnum::class,
        ];
    }
}
