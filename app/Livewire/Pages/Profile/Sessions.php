<?php

namespace App\Livewire\Pages\Profile;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use WhichBrowser\Parser;

class Sessions extends Component
{
    public Collection $sessions;

    public function mount()
    {
        $currentUser = Auth::user();
        $this->sessions = DB::table('sessions')->where('user_id', $currentUser->id)->get()->map(function ($session) use ($currentUser) {
            $result = new Parser($session->user_agent);
            // get latest activity in diffHuman format
            $session->last_activity = Carbon::parse($session->last_activity)->diffForHumans();
            $ipInfo = Cache::remember("user:{$currentUser->id}:ip:79.173.245.138", 3600, function () use ($session) {
                $token = env('IP_INFO_TOKEN');
                return json_decode(file_get_contents("http://ipinfo.io/79.173.245.138?token={$token}"));
            });
            return [
                'id' => $session->id,
                'last_activity' => $session->last_activity,
                'ip_address' => $session->ip_address,
                'browser' => $result->browser->toString(),
                'platform' => $result->os->toString(),
                'device' => $result->device->type,
                'city' => $ipInfo->city,
                'region' => $ipInfo->region,
                'country' => $ipInfo->country,
                'loc' => explode(',', $ipInfo->loc),
                "current" => $session->id === session()->getId(),
            ];
        });
    }

    public function closeSession($sessionId)
    {
        DB::table('sessions')->where('id', $sessionId)->delete();
        $this->sessions = $this->sessions->reject(function ($session) use ($sessionId) {
            return $session['id'] === $sessionId;
        });
    }

    public function render()
    {
        return view('livewire.pages.profile.sessions', [
            'sessions' => $this->sessions,
        ])->extends('components.layouts.app');
    }
}
