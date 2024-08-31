<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\HasUser;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class Message extends Model
{
    use Cachable, HasFactory, HasUser;

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
     * Get the user that owns the Message
     */
    public function replay(): HasMany
    {
        return $this->hasMany(MessageReplay::class, 'message_id');
    }

    public function likes()
    {
        return $this->hasMany(MessageLike::class, 'message_id');
    }

    public function favorites()
    {
        return $this->hasMany(MessageFavourite::class, 'message_id');
    }
}
