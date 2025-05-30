<?php

declare(strict_types=1);

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\AccessTokenAdditionalInfo;
use App\Models\User;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;

final class SessionController extends Controller
{
    /**
     * Show the user's sessions page.
     */
    public function index(Request $request): \Illuminate\Http\JsonResponse
    {
        $user = type($request->user())->as(User::class);

        $sessions = $user->sessions()->orderBy('last_activity', 'desc')->get()->map(function (AccessTokenAdditionalInfo $session): array {
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

        return $this->responseFormatter->responseSuccess('', [
            'sessions' => $sessions,
        ]);

    }

    public function destroy(Request $request): \Illuminate\Http\JsonResponse
    {
        $user = type($request->user())->as(User::class);
        $session = $user->sessions()->find($request->session_id);
        if ($session) {
           $accessToken =  $user->tokens()->where('id', $session->access_token_id);
            if ($accessToken) {
                $accessToken->delete();
                $session->delete();
                return $this->responseFormatter->responseSuccess('Session deleted successfully');
            }
            return $this->responseFormatter->responseError('Session not found', 404);
        }
        return $this->responseFormatter->responseError('Session not found', 404);
    }
}
