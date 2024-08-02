<?php

namespace App\Providers;

use App\Livewire\Component\Notification\DropDown as NotificationDropDown;
use App\Livewire\Component\User\HomeCard as UserHomeCard;
use App\Livewire\Layout\SidePanel;
use App\Models\User;
use App\View\Components\Layouts\App;
use App\View\Components\Layouts\Guest;
use App\View\Components\UserHeaderCard;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->register(
            \Laravel\Telescope\TelescopeServiceProvider::class,
        );
        $this->app->register(TelescopeServiceProvider::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Blade::component('layout-app', App::class);
        Livewire::component('user::home-card', UserHomeCard::class);
        Livewire::component('layout::side-panel', SidePanel::class);
        Route::bind('user', function (string $value) {
            return User::where('username', $value)->firstOrFail();
        });
        Blade::component('layout-guest', Guest::class);
        Blade::component('user-header-card', UserHeaderCard::class);
        Livewire::component(
            'notification::dropdown',
            NotificationDropDown::class,
        );
        Gate::define('viewPulse', function (User $user) {
            return str_contains($user->email, '@yanalshoubaki.com');
        });
        Livewire::setScriptRoute(function ($handle) {
            return Route::get('/vendor/livewire/livewire.js', $handle);
        });
    }
}
