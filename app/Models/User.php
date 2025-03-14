<?php

namespace App\Models;

use App\Enums\UserStatusEnum;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Scout\Searchable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements FilamentUser
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

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->hasRole('super-admin');
    }

    /**
     * Get the user's messages.
     *
     * @return HasMany<Message>
     */
    public function messages(): HasMany
    {
        return $this->hasMany(Message::class, 'user_id');
    }

    /**
     * Get the user's social connections.
     *
     * @return HasMany<UserSocialAuth>
     */
    public function socialConnections(): HasMany
    {
        return $this->hasMany(UserSocialAuth::class, 'user_id');
    }

    /**
     * Get the user's followers.
     *
     * @return HasMany<UserFollower>
     */
    public function followers(): HasMany
    {
        return $this->hasMany(UserFollow::class, 'user_id');
    }

    /**
     * Get the user's following.
     *
     * @return HasMany<UserFollower>
     */
    public function followings(): HasMany
    {
        return $this->hasMany(UserFollow::class, 'follower_id');
    }

    /**
     * Check if the user is following another user.
     */
    public function isFollowing(User $user): bool
    {
        return $this->followings()->where('user_id', $user->id)->exists();
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
     * @return array<string, mixed>
     */
    public function toSearchableArray(): array
    {
        $array = $this->toArray();

        // Customize the data array...

        return $array;
    }

    public function favouriteMessages()
    {
        return $this->hasMany(MessageFavourite::class, 'user_id');
    }

    public function deactivate(): void
    {
        $this->status = UserStatusEnum::DEACTIVATED;
        $this->save();
    }
}
