<?php

declare(strict_types=1);

namespace App\Http\Controllers\Settings;

use App\Enums\SocialProvidersEnum;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

final class SecurityController extends Controller
{
    /**
     * Show the user's profile settings page.
     */
    public function edit(Request $request): Response
    {
        $user = type($request->user())->as(User::class);
        $socialConnections = $user->socialConnections()->get();

        $socialConnections = collect(SocialProvidersEnum::cases())->map(fn ($provider): array => [
            'provider' => $provider->value,
            'provider_name' => $provider->value,
            'connected' => $socialConnections->contains('provider', $provider->value),
        ]);

        return Inertia::render('settings/security', [
            'socialConnections' => $socialConnections,
        ]);
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = type($request->user())->as(User::class);

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return to_route('welcome');
    }

    public function deactivate(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = type($request->user())->as(User::class);

        Auth::logout();

        $user->deactivate();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return to_route('welcome', [
            'message' => 'Your account has been deactivated.',
        ]);
    }
}
