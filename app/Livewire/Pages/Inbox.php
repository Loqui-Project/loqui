<?php

namespace App\Livewire\Pages;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class Inbox extends Component
{
    public Collection $messages;
    public User $user;



    public function mount()
    {
        if (!Auth::check()) {
            return redirect()->route('auth.sign-in');
        }
        $this->user = Auth::user();
        $this->messages = $this->user->messages()->doesntHave('replay')->get();
    }

    #[On('add-replay')]
    public function refreshMessages()
    {
        $this->messages = $this->user->messages()->doesntHave('replay')->get();
    }


    public function render()
    {
        return view('livewire.pages.inbox', [
            'user' => $this->user,
            "messages" => $this->messages
        ])->extends('components.layouts.app');
    }
}
