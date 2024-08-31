<?php

declare(strict_types=1);

namespace App\Traits;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasUser
{
    /**
     * Get the user that owns the model.
     *
     * @return BelongsTo<User, User>
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
