<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Spatie\Health\Checks\Checks;
use Spatie\Health\Facades\Health;

final class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        if ($this->app->environment('local') && class_exists(\Laravel\Telescope\TelescopeServiceProvider::class)) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        if ($this->app->environment('production')) {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }
        Event::listen(function (\SocialiteProviders\Manager\SocialiteWasCalled $event): void {
            $event->extendSocialite('facebook', \SocialiteProviders\Facebook\Provider::class);
            $event->extendSocialite('google', \SocialiteProviders\Google\Provider::class);
        });

        Health::checks([
            Checks\OptimizedAppCheck::new(),
            Checks\DebugModeCheck::new(),
            Checks\EnvironmentCheck::new(),
            Checks\DatabaseCheck::new(),
            Checks\BackupsCheck::new(),
            Checks\MeiliSearchCheck::new(),
            Checks\RedisCheck::new(),
            Checks\QueueCheck::new(),
        ]);
    }
}
