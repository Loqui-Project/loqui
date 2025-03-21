<?php

namespace App\Models;

use App\Traits\HasUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Message extends Model
{
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
    ];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    /**
     * Get the user that owns the MessageCard
     */
    public function replays(): HasMany
    {
        return $this->hasMany(MessageReplay::class, 'message_id');
    }

    public function likes(): HasMany
    {
        return $this->hasMany(MessageLike::class, 'message_id');
    }

    public function favorites()
    {
        return $this->hasMany(MessageFavourite::class, 'message_id');
    }

    // get only messages without replies
    public function scopeWithoutReplies($query)
    {
        return $query->whereDoesntHave('replays');
    }

    // get only messages with replies
    public function scopeWithReplies($query)
    {
        return $query->whereHas('replays');
    }
}
