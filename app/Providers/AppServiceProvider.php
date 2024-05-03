<?php

namespace App\Providers;

use App\Models\User;
use App\Module\Logger\LoggerServiceProvider;
use App\View\Components\Component\Modal;
use App\View\Components\Component\ModalBody;
use App\View\Components\Component\ModalButton;
use App\View\Components\Layouts\App;
use App\View\Components\Layouts\Guest;
use App\View\Components\User\HomeCard;
use App\View\Components\UserHeaderCard;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
        $this->app->register(TelescopeServiceProvider::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Blade::component('layout-app', App::class);
        Blade::component('modal', Modal::class);
        Blade::component('modal-body', ModalBody::class);
        Blade::component('modal-button', ModalButton::class);
        Blade::component('user::home-card', HomeCard::class);
        Blade::component('layout-guest', Guest::class);
        Blade::component('user-header-card', UserHeaderCard::class);
        Gate::define('viewPulse', function (User $user) {
            return str_contains($user->email, '@yanalshoubaki.com');
        });
    }
}
