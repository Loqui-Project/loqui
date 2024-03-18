<?php

namespace App\Traits;

use App\Models\MediaObject;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasMediaObject
{
    /**
     * Get the media object that owns the model.
     */
    public function mediaObject(): BelongsTo
    {
        return $this->belongsTo(MediaObject::class, 'media_object_id', 'id');
    }
}
