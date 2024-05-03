<?php

namespace App\Livewire\Pages;

use App\Models\Message;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class Home extends Component
{
    public User $authUser;

    public Collection $userMessages;

    public array $userData = [];

    public function mount()
    {
        if (! Auth::check()) {
            return redirect()->route('auth.sign-in');
        }

        $this->authUser = Auth::user()->load('follower', 'following', 'messages');
        $this->userMessages = Cache::driver('redis')->remember("user:{$this->authUser->id}:messages:with_replay", 60 * 60 * 24 * 1, function () {
            return Message::whereIn('user_id', $this->authUser->following->pluck('id'))->whereHas('replay')->with(['replay', 'user.mediaObject', 'sender.mediaObject', 'likes', 'favorites'])->latest()->get();
        });
        $this->userData = Cache::driver('redis')->remember("user:{$this->authUser->id}:data", 60 * 60 * 24 * 1, function () {
            return [
                'followers' => [
                    'count' => $this->authUser->follower->count(),
                    'data' => $this->authUser->follower->take(5),
                ],
                'following' => [
                    'count' => $this->authUser->following->count(),
                    'data' => $this->authUser->following->take(5),
                ],
                'messages' => $this->authUser->messages->count(),
            ];
        });
    }

    public function render()
    {
        return view('livewire.pages.home', [
            'user' => $this->authUser,
            'messages' => $this->userMessages,
        ])->extends('components.layouts.app');
    }
}
