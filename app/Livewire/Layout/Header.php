<?php

namespace App\Livewire\Layout;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Header extends Component
{
    public ?User $user;

    public function mount()
    {
        // get username from request
        $username = Auth::user()->username ?? request()->route('username');
        $this->user = User::where('username', $username)->first();
    }

    public function render()
    {
        return view('livewire.layout.header');
    }
}
