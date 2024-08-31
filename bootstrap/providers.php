<?php

declare(strict_types=1);

return [
    App\Providers\AppServiceProvider::class,
    App\Providers\Filament\AdminPanelProvider::class,
    Intervention\Image\ImageServiceProvider::class,
    Laravel\Socialite\SocialiteServiceProvider::class,
    Sentry\SentryLaravel\SentryLaravelServiceProvider::class,
];
