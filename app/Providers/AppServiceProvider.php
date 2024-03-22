<?php

namespace App\Providers;

use App\View\Components\Layouts\App;
use App\View\Components\Layouts\Guest;
use App\View\Components\Layouts\Partial\Header;
use App\View\Components\UserHeaderCard;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

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
        Blade::component('header', Header::class);
        Blade::component('layout-guest', Guest::class);
        Blade::component('user-header-card', UserHeaderCard::class);
    }
}
