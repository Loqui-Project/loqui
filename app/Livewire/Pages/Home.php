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

        $this->authUser = Cache::get('user:'.Auth::id(), function () {
            return User::find(Auth::id());
        });
        $this->userMessages = Cache::remember("user:{$this->authUser->id}:messages:with_replay", now()->addHours(4), function () {
            return Message::whereIn('user_id', collect([$this->authUser->id])->merge($this->authUser->following->pluck('id')))->whereHas('replay')->with(['replay', 'user.mediaObject', 'sender.mediaObject', 'likes.user', 'favorites'])->latest()->get();
        });
        $this->userData = Cache::remember("user:{$this->authUser->id}:data", now()->addHours(4), function () {
            return [
                'followers' => [
                    'count' => $this->authUser->followers->count(),
                    'data' => $this->authUser->followers->take(5),
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
