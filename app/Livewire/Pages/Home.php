<?php

namespace App\Livewire\Pages;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Home extends Component
{

    public function mount()
    {
        if (!Auth::check()) {
            return redirect()->route('auth.sign-in');
        }

    }

    public function render()
    {
        /* @var \App\Models\User $user */
        $user = Auth::user();
        $messages = $user->messages()->whereHas('replay')->get();
        return view('livewire.pages.home', [
            'user' => $user,
            "messages" => $messages
        ])->extends('components.layouts.app');
    }
}
