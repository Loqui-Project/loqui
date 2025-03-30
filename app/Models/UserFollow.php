<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $user_id
 * @property int $follower_id
 * @property-read User $user
 * @property-read User $follower
 */
final class UserFollow extends Model
{
    protected $fillable = [
        'user_id',
        'follower_id',
    ];

    /**
     * Get the user that owns the UserFollow
     *
     * @return BelongsTo<User, covariant $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the user that owns the UserFollow
     *
     * @return BelongsTo<User, covariant $this>
     */
    public function follower(): BelongsTo
    {
        return $this->belongsTo(User::class, 'follower_id');
    }
}
