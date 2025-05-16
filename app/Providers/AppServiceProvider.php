<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\Message;
use App\Policies\MessagePolicy;
use App\Services\AuthService;
use App\Services\ResponseFormatter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;
use SocialiteProviders\Google\Provider;
use SocialiteProviders\Manager\SocialiteWasCalled;
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
        Model::preventLazyLoading();

        $this->app->bind(AuthService::class);
        $this->app->bind(ResponseFormatter::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        JsonResource::withoutWrapping();

        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }
        Event::listen(function (SocialiteWasCalled $event): void {
            $event->extendSocialite('facebook', \SocialiteProviders\Facebook\Provider::class);
            $event->extendSocialite('google', Provider::class);
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

        Passport::enablePasswordGrant();

        Gate::policy(Message::class, MessagePolicy::class);

    }
}
