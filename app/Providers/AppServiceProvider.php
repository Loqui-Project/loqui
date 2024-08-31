<?php

declare(strict_types=1);

namespace App\Providers;

use App\Livewire\Component\Notification\DropDown as NotificationDropDown;
use App\Livewire\Component\User\FollowButton;
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

final class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void {}

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Blade::component('layout-app', App::class);
        Livewire::component('user::home-card', UserHomeCard::class);
        Livewire::component('user::follow-button', FollowButton::class);
        Livewire::component('layout::side-panel', SidePanel::class);
        Route::bind('user', fn (string $value) => User::where('username', $value)->firstOrFail());
        Blade::component('layout-guest', Guest::class);
        Blade::component('user-header-card', UserHeaderCard::class);
        Livewire::component(
            'notification::dropdown',
            NotificationDropDown::class,
        );
        Gate::define('viewPulse', fn (User $user): bool => str_contains($user->email, '@yanalshoubaki.com'));
        Livewire::setScriptRoute(fn ($handle) => Route::get('/vendor/livewire/livewire.js', $handle));
    }
}
