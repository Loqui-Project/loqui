<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\HasUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property string $provider
 * @property string $provider_id
 * @property-read User $user
 */
final class UserSocialAuth extends Model
{
    /** @use HasFactory<\Database\Factories\UserSocialAuthFactory> */
    use HasFactory;

    use HasUser;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'provider',
        'provider_id',
    ];
}
