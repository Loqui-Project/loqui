<?php

namespace App\Models;

use App\Traits\HasUser;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationSettings extends Model
{
    use Cachable, HasFactory, HasUser;

    protected $fillable = ['user_id', 'type', 'key', 'value'];
}
