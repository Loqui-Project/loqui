<?php

declare(strict_types=1);

namespace App\Enums;

enum SocialProvidersEnum: string
{
    case FACEBOOK = 'facebook';
    case GOOGLE = 'google';

    public static function toArray(): array
    {
        return [
            self::FACEBOOK->value => 'Facebook',
            self::GOOGLE->value => 'Google',
        ];
    }
}
