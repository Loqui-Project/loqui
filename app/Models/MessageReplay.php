<?php

namespace App\Models;

use App\Traits\HasUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MessageReplay extends Model
{
    /** @use HasFactory<\Database\Factories\MessageReplayFactory> */
    use HasFactory;

    use HasUser;

    protected $fillable = [
        'user_id',
        'message_id',
        'text'
    ];

    public function message()
    {
        return $this->belongsTo(Message::class);
    }
}
