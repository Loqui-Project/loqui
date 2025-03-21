<?php

declare(strict_types=1);

namespace App\Enums;

enum NotificationType: string
{
    case NEW_MESSAGE = 'new-message';

    case NEW_LIKE = 'new-like';

    case NEW_REPLY = 'new-reply';

    case NEW_FOLLOWER = 'new-follower';

    public function getLabel(): string
    {
        return match ($this) {
            self::NEW_FOLLOWER => 'New Follower',
            self::NEW_LIKE => 'New Like',
            self::NEW_MESSAGE => 'New Message',
            self::NEW_REPLY => 'New Reply',
        };
    }
}
