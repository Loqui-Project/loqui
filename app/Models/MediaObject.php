<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MediaObject extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'media_path',
    ];

    public function user()
    {
        return $this->hasMany(User::class, 'media_object_id', 'id');
    }
}
