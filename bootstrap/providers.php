<?php

return [
    App\Providers\AppServiceProvider::class,
    App\Providers\BroadcastServiceProvider::class,
    App\Providers\Filament\AdminPanelProvider::class,
    App\Providers\TelescopeServiceProvider::class,
    Intervention\Image\ImageServiceProvider::class,
    Laravel\Socialite\SocialiteServiceProvider::class,
    Sentry\SentryLaravel\SentryLaravelServiceProvider::class,
];
