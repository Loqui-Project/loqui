<?php

namespace App;

enum NotificationTypeEnum: string
{
    case NEW_MESSAGE = 'new-message';
    case NEW_LIKE = 'new-like';
    case NEW_FOLLOWER = 'new-follower';

    case NEW_REPlAY = 'new-replay';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
