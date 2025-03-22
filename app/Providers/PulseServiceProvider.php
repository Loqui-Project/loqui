<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Laravel\Pulse\Facades\Pulse;

final class PulseServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Gate::define('viewPulse', fn (User $user): bool => $user->hasRole('super-admin'));

        Pulse::user(fn (User $user): array => [
            'name' => $user->name,
            'extra' => $user->email,
            'avatar' => $user->image_url ? asset('storage/'.$user->image_url) : '/images/default-avatar.png',
        ]);
    }
}
