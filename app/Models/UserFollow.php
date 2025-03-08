<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserFollow extends Model
{
    /** @use HasFactory<\Database\Factories\UserFollowFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'follower_id',
    ];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function follower(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'follower_id');
    }
}
