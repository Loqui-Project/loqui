<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

final class AccessTokenAdditionalInfo extends Model
{
    protected $fillable = ['access_token_id', 'ip_address', 'user_agent', 'last_activity', 'user_id'];

    public function isCurrentDevice(): bool
    {
        if (Auth::user() === null) {
            return false;
        }

        return $this->access_token_id === Auth::user()->currentAccessToken()->id;
    }

    /**
     * Last Activity Carbon instance
     */
    public function getLastActivityAtAttribute(): Carbon
    {
        return Carbon::createFromTimestamp($this->last_activity);
    }
}
