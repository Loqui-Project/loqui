<?php

namespace App\Livewire\Layout;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class Header extends Component
{
    public ?User $user;

    public function mount()
    {
        $username = Auth::user()->username ?? request()->route('username');
        $this->user = Cache::remember('user:'.Auth::id(), now()->addHours(4), function () use ($username) {
            return User::where('username', $username)->first() ?? null;
        });
    }

    public function render()
    {
        return view('livewire.layout.header');
    }
}
