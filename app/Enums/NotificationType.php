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

    public function getDescription(): string
    {
        return match ($this) {
            self::NEW_FOLLOWER => 'Get notified when someone follows you',
            self::NEW_LIKE => 'Get notified when someone likes your message',
            self::NEW_MESSAGE => 'Get notified when someone sends you a message',
            self::NEW_REPLY => 'Get notified when someone replies to your message',
        };
    }
}
