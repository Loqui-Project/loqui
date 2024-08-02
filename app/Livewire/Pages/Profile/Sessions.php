<?php

namespace App\Livewire\Pages\Profile;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Title;
use Livewire\Component;
use WhichBrowser\Parser;

class Sessions extends Component
{
    public Collection $sessions;

    public function mount()
    {
        $currentUser = Auth::user();
        $this->sessions = DB::table('sessions')
            ->where('user_id', $currentUser->id)
            ->get()
            ->map(function ($session) use ($currentUser) {
                $result = new Parser($session->user_agent);
                // get latest activity in diffHuman format
                $session->last_activity = Carbon::parse(
                    $session->last_activity,
                )->diffForHumans();
                $ipInfo = Cache::remember(
                    "user:{$currentUser->id}:ip:{$session->ip_address}",
                    3600,
                    function () use ($session) {
                        $token = env('IP_INFO_TOKEN');

                        return json_decode(
                            file_get_contents(
                                "http://ipinfo.io/{$session->ip_address}?token={$token}",
                            ),
                        );
                    },
                );
                if ($ipInfo->ip != '127.0.0.1') {

                    return [
                        'id' => $session->id,
                        'last_activity' => $session->last_activity,
                        'ip_address' => $session->ip_address,
                        'browser' => $result->browser->toString(),
                        'platform' => $result->os->toString(),
                        'device' => $result->device->type,
                        'city' => $ipInfo ? $ipInfo->city : 'Unknown',
                        'region' => $ipInfo ? $ipInfo->region : 'Unknown',
                        'country' => $ipInfo ? $ipInfo->country : 'Unknown',
                        'loc' => $ipInfo ? explode(',', $ipInfo->loc) : 'Unknown',
                        'current' => $session->id === session()->getId(),
                    ];
                } else {
                    return [
                        'id' => $session->id,
                        'last_activity' => $session->last_activity,
                        'ip_address' => $session->ip_address,
                        'browser' => $result->browser->toString(),
                        'platform' => $result->os->toString(),
                        'device' => $result->device->type,
                        'city' => 'Unknown',
                        'region' => 'Unknown',
                        'country' => 'Unknown',
                        'loc' => 'Unknown',
                        'current' => $session->id === session()->getId(),
                    ];
                }
            });
    }

    public function endAllSessions()
    {
        // except current session
        DB::table('sessions')
            ->where('user_id', Auth::id())
            ->where('id', '!=', session()->getId())
            ->delete();
        $this->sessions = $this->sessions->reject(function ($session) {
            return ! $session['current'];
        });
    }

    public function closeSession($sessionId)
    {
        DB::table('sessions')->where('id', $sessionId)->delete();
        $this->sessions = $this->sessions->reject(function ($session) use (
            $sessionId,
        ) {
            return $session['id'] === $sessionId;
        });
    }

    #[Title('Sessions')]
    public function render()
    {
        return view('livewire.pages.profile.sessions', [
            'sessions' => $this->sessions,
        ]);
    }
}
