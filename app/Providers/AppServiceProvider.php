<?php

namespace App\Providers;

use App\Models\User;
use App\View\Components\Layouts\App;
use App\View\Components\Layouts\Guest;
use App\View\Components\UserHeaderCard;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Blade::component('layout-app', App::class);
        Blade::component('layout-guest', Guest::class);
        Blade::component('user-header-card', UserHeaderCard::class);
        Gate::define('viewPulse', function (User $user) {
            return str_contains($user->email, '@yanalshoubaki.com');
        });
    }
}
