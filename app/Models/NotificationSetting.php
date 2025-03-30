<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\NotificationChannel;
use App\Enums\NotificationType;
use App\Traits\HasUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $user_id
 * @property NotificationChannel $key
 * @property NotificationType $type
 * @property string $value
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property-read User $user
 */
final class NotificationSetting extends Model
{
    use HasUser;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'key',
        'type',
        'value',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'key' => NotificationChannel::class,
            'type' => NotificationType::class,
        ];
    }
}
