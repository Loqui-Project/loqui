<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasUser
{
    /**
     * Get the user that owns the model.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
