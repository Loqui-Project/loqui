<?php

namespace App\Models;

use App\Traits\HasUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;
    use HasUser;

    protected $fillable = [
        'user_id',
        'sender_id',
        'message',
        'is_anon',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function replay()
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
