<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserFollow extends Model
{
    /** @use HasFactory<\Database\Factories\UserFollowFactory> */
    use HasFactory;

    protected $fillable = [
        'follower_id',
        'following_id',
    ];

    public function follower(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'follower_id');
    }

    public function following(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'following_id');
    }
}
