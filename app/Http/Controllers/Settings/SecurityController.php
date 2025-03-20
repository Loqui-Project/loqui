<?php

namespace App\Http\Controllers\Settings;

use App\Enums\SocialProvidersEnum;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class SecurityController extends Controller
{
    /**
     * Show the user's profile settings page.
     */
    public function edit(Request $request): Response
    {
        $socialConnections = $request->user()->socialConnections()->get();

        $socialConnections = collect(SocialProvidersEnum::toArray())->map(function ($providerName, $provider) use ($socialConnections) {
            return [
                'provider' => $provider,
                'provider_name' => $providerName,
                'connected' => $socialConnections->contains('provider', $provider),
            ];
        });

        return Inertia::render('settings/security', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => $request->session()->get('status'),
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

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function deactivate(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->deactivate();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
