<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\HasUser;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $user_id
 * @property int $sender_id
 * @property string $message
 * @property bool $is_anon
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property-read User $user
 * @property-read ?User $sender
 * @property-read MessageReplay[] $replays
 * @property-read MessageLike[] $likes
 * @property-read MessageFavourite[] $favorites
 */
final class Message extends Model
{
    use Cachable;

    /** @use HasFactory<\Database\Factories\MessageFactory> */
    use HasFactory;

    use HasUser;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'sender_id',
        'message',
        'is_anon',
        'image_url',
    ];

    /**
     * Get the user that owns the Message
     *
     * @return BelongsTo<User, covariant $this>
     */
    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    /**
     * Get the user that owns the MessageCard
     *
     * @return HasMany<MessageReplay, covariant $this>
     */
    public function replays(): HasMany
    {
        return $this->hasMany(MessageReplay::class, 'message_id');
    }

    /**
     * Get likes for the message
     *
     * @return HasMany<MessageLike, covariant $this>
     */
    public function likes(): HasMany
    {
        return $this->hasMany(MessageLike::class, 'message_id');
    }

    /**
     * Get favorites for the message
     *
     * @return HasMany<MessageFavourite, covariant $this>
     */
    public function favorites(): HasMany
    {
        return $this->hasMany(MessageFavourite::class, 'message_id');
    }

    /**
     * Scope messages with replay.
     *
     * @param  \Illuminate\Database\Eloquent\Builder<static>  $query
     * @return \Illuminate\Database\Eloquent\Builder<static>
     */
    #[Scope]
    public function withReplies(Builder $query): Builder
    {
        return $query->whereHas('replays');
    }

    /**
     * Scope messages with replay.
     *
     * @param  \Illuminate\Database\Eloquent\Builder<static>  $query
     * @return \Illuminate\Database\Eloquent\Builder<static>
     */
    #[Scope]
    public function withoutReplies(Builder $query): Builder
    {
        return $query->doesntHave('replays');
    }
}
