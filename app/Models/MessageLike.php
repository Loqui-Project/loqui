<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\HasUser;
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
final class MessageLike extends Model
{
    /** @use HasFactory<\Database\Factories\MessageLikeFactory> */
    use HasFactory;

    use HasUser;

    protected $fillable = [
        'user_id',
        'message_id',
    ];

    /**
     * Get the message that owns the MessageLike
     *
     *   @return BelongsTo<Message, covariant $this>
     */
    public function message(): BelongsTo
    {
        return $this->belongsTo(Message::class);
    }
}
