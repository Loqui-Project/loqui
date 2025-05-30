<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class AccessTokenAdditionalInfo extends Model
{

    public function isCurrentDevice(): bool
    {
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
