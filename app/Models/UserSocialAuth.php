<?php

namespace App\Models;

use App\Traits\HasUser;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSocialAuth extends Model
{
    use HasFactory, HasUser, Cachable;

    protected $fillable = [
        'user_id',
        'provider',
        'provider_id',
    ];
}
