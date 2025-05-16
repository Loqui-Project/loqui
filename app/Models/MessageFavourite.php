<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\MessageFavouriteFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $user_id
 * @property int $message_id
 * @property-read User $user
 * @property-read Message $message
 */
final class MessageFavourite extends Model
{
    /** @use HasFactory<MessageFavouriteFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'message_id',
    ];

    /**
     * Get the message that owns the MessageFavourite
     *
     * @return BelongsTo<Message, covariant $this>
     */
    public function message(): BelongsTo
    {
        return $this->belongsTo(Message::class);
    }

    /**
     * Get the user that owns the MessageFavourite
     *
     * @return BelongsTo<User, covariant $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
