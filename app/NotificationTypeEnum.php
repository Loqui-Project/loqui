<?php

namespace App;

enum NotificationTypeEnum: string
{
    case NEW_MESSAGE = 'new_message';
    case NEW_LIKE = 'new_like';
    case NEW_FOLLOWER = 'new_follower';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
