<?php

namespace App\Models;

use App\Traits\HasUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    use HasUser;

    protected $fillable = [
        'user_id',
        'type',
        'data',
        'read_at',
    ];


    protected $casts = [
        'data' => 'array',
        'read_at' => 'datetime',
        "created_at" => 'datetime',
    ];

    public function markAsRead()
    {
        $this->read_at = now();
        $this->save();
    }

    public function markAsUnread()
    {
        $this->read_at = null;
        $this->save();
    }

    public function isRead(): bool
    {
        return $this->read_at !== null;
    }

    public function isUnread(): bool
    {
        return !$this->isRead();
    }

    public function isType(string $type): bool
    {
        return $this->type === $type;
    }

    public function scopeUnread()
    {
        return $this->whereNull('read_at');
    }

}
