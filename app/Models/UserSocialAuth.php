<?php

namespace App\Models;

use App\Traits\HasUser;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSocialAuth extends Model
{
    use Cachable, HasFactory, HasUser;

    protected $fillable = [
        'user_id',
        'provider',
        'provider_id',
    ];
}
