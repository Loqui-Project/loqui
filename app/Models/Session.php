<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\HasUser;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

final class Session extends Model
{
    use HasUser;

    /**
     * Indicates if the model should auto increment.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * Indicates if the model has no timestamps
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The data type of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * The table associated with the model.
     *
     * @var string|null
     */
    protected $table = 'sessions';

    /**
     * Get Unserialized Payload (base64 decoded too)
     */
    public function getUnserializedPayloadAttribute(): mixed
    {
        return unserialize(base64_decode($this->payload));
    }

    /**
     * Manually set Payload (base64 encoded / serialized)
     *
     * @return void
     */
    public function setPayload(string $payload)
    {
        $this->payload = serialize(base64_encode($payload));
        $this->save();
    }

    public function isCurrentDevice(): bool
    {

        return $this->id === session()->getId();
    }

    /**
     * Last Activity Carbon instance
     */
    public function getLastActivityAtAttribute(): Carbon
    {
        return Carbon::createFromTimestamp($this->last_activity);
    }
}
