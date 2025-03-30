<?php

declare(strict_types=1);

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Jenssegers\Agent\Agent;

final class SessionController extends Controller
{
    /**
     * Show the user's sessions page.
     */
    public function index(Request $request): \Inertia\Response
    {
        $user = type($request->user())->as(User::class);
        $sessions = $user->sessions()->orderBy('last_activity', 'desc')->get()->map(function ($session): array {
            $agent = new Agent();
            $agent->setUserAgent($session->user_agent);

            return [
                'id' => $session->id,
                'agent' => [
                    'platform' => $agent->platform(),
                    'browser' => $agent->browser(),
                    'device' => $agent->device(),
                ],
                'ip_address' => $session->ip_address,
                'is_current_device' => $session->isCurrentDevice(),
                'last_activity' => $session->last_activity,
            ];
        });

        return Inertia::render('settings/sessions', [
            'sessions' => $sessions,
        ]);
    }

    public function destroy(Request $request, int $session): \Illuminate\Http\RedirectResponse
    {
        $user = type($request->user())->as(User::class);
        $user->sessions()->where('id', $session)->delete();

        return redirect()->route('sessions.index');
    }
}
