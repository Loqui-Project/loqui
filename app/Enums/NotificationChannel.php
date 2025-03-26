<?php

declare(strict_types=1);

namespace App\Enums;

enum NotificationChannel: string
{
    case EMAIL = 'email';
    case DATABASE = 'database';
    case BROWSER = 'browser';

    public function getLabel(): string
    {
        return match ($this) {
            self::EMAIL => 'Email',
            self::DATABASE => 'Database',
            self::BROWSER => 'Browser',
        };
    }

    public function getDescription(): string
    {
        return match ($this) {
            self::EMAIL => 'Get notified via email',
            self::DATABASE => 'Get notified via database',
            self::BROWSER => 'Get notified via browser',
        };
    }
}
