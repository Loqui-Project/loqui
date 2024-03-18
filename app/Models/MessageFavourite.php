<?php

namespace App\Models;

use App\Traits\HasUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MessageFavourite extends Model
{
    use HasFactory;
    use HasUser;

    protected $fillable = [
        'user_id',
        'message_id',
    ];

    public function message()
    {
        return $this->belongsTo(Message::class);
    }
}
