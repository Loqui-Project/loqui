<?php

declare(strict_types=1);

namespace App\Providers;

use App\Listeners\CreateSessionOnTokenCreated;
use App\Models\Message;
use App\Models\User;
use App\Policies\MessagePolicy;
use App\Services\AuthService;
use App\Services\ResponseFormatter;
use Carbon\CarbonInterval;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Events\AccessTokenCreated;
use Laravel\Passport\Passport;
use Laravel\Sanctum\Events\TokenAuthenticated;
use SocialiteProviders\Google\Provider;
use SocialiteProviders\Manager\SocialiteWasCalled;
use Spatie\Health\Checks\Checks;
use Spatie\Health\Facades\Health;
use Illuminate\Auth\Notifications\ResetPassword;


final class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // if ($this->app->environment('local') && class_exists(\Laravel\Telescope\TelescopeServiceProvider::class)) {
        //     $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
        //     $this->app->register(TelescopeServiceProvider::class);
        // }

        $this->app->bind(AuthService::class);
        $this->app->bind(ResponseFormatter::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        VerifyEmail::toMailUsing(function (object $notifiable, string $url) {

            $parsedUrl = parse_url($url);
            $pathSegments = explode('/', trim($parsedUrl['path'], '/'));
            if (count($pathSegments) < 3) {
                throw new \Exception('Invalid URL structure. Expected at least 3 segments.');
            }

            $id = $pathSegments[2]; // The `id` should be the second segment
            $hash = $pathSegments[3]; // The `hash` should be the third segment

            parse_str($parsedUrl['query'], $queryParams);
            if (!isset($queryParams['signature'])) {
                throw new \Exception('Missing signature parameter in URL.');
            }

            $frontendUrl = config('app.frontend_url') . '/email/verify?' . http_build_query([
                'id' => $id,
                'hash' => $hash,
                'expires' => $queryParams['expires'],
                'signature' => $queryParams['signature'],
            ]);
            // i need the queries from the url and put them in the front end url
            return (new \Illuminate\Notifications\Messages\MailMessage)
                ->line('Please click the button below to verify your email address.')
                ->action('Verify Email Address',  $frontendUrl)
                ->line('Thank you for using our application!');
        });

        ResetPassword::createUrlUsing(function (User $user, string $token) {
            return config('app.frontend_url') . '/reset-password/' . $token . '?email=' . urlencode($user->getEmailForPasswordReset());
        });
        JsonResource::withoutWrapping();

        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }
        Event::listen(function (SocialiteWasCalled $event): void {
            $event->extendSocialite('facebook', \SocialiteProviders\Facebook\Provider::class);
            $event->extendSocialite('google', Provider::class);
        });

        Gate::define('viewPulse', function (User $user) {
            return $user->isAdmin();
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


        Gate::policy(Message::class, MessagePolicy::class);

        Event::listen(
            TokenAuthenticated::class,
            CreateSessionOnTokenCreated::class,
        );
    }
}
