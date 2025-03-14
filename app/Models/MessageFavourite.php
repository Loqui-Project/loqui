<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MessageFavourite extends Model
{
    /** @use HasFactory<\Database\Factories\MessageFavouriteFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'message_id',
    ];

    public function message()
    {
        return $this->belongsTo(Message::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
