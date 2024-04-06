<?php

namespace App\Livewire\Pages;

use App\Models\Message;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\On;
use Livewire\Component;

class Inbox extends Component
{
    public Collection $userMessages;

    public User $user;

    public function mount()
    {
        if (!Auth::check()) {
            return redirect()->route('auth.sign-in');
        }
        $this->user = Auth::user();
        $this->userMessages = Cache::driver('redis')->remember("user:{$this->user->id}:messages:without_replay", 60 * 60 * 24 * 1, function () {
            return Message::where('user_id', $this->user->id)->doesntHave('replay')->with(["user.mediaObject", "sender.mediaObject"])->latest()->get();
        });
    }

    #[On('add-replay')]
    public function refreshMessages()
    {
        Cache::driver('redis')->forget("user:{$this->user->id}:messages:without_replay");
    }

    public function render()
    {
        return view('livewire.pages.inbox', [
            'user' => $this->user,
            'messages' => $this->userMessages,
        ])->extends('components.layouts.app');
    }
}
