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

    public function mount()
    {
        if (!Auth::check()) {
            return redirect()->route('auth.sign-in');
        }
        $this->authUser = Auth::user();
        $this->userMessages = Cache::driver("redis")->remember("user:{$this->authUser->id}:messages:with_replay", 60 * 60 * 24 * 1, function () {
            // get messages from my following users
            return Message::whereIn('user_id', $this->authUser->following->pluck('id'))->whereHas('replay')->latest()->get();
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
