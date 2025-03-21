<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\HasUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $user_id
 * @property int $message_id
 * @property string $text
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property-read User $user
 * @property-read Message $message
 */
final class MessageReplay extends Model
{
    /** @use HasFactory<\Database\Factories\MessageReplayFactory> */
    use HasFactory;

    use HasUser;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'message_id',
        'text',
    ];

    /**
     * Get the message that owns the MessageReplay
     *
     * @return BelongsTo<Message, covariant $this>
     */
    public function message(): BelongsTo
    {
        return $this->belongsTo(Message::class);
    }
}
