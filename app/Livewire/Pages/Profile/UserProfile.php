<?php

namespace App\Livewire\Pages\Profile;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Component;

class UserProfile extends Component
{


    public $user;
    public bool $isFollowing = false;
    public bool $anonymously = false;

    public Collection $messages;

    #[Validate("required|string|min:2")]
    public string $message = "";

    public function mount($username)
    {
        $this->user = User::where("username", $username)->first();
        if (Auth::check()) {
            $this->isFollowing = Auth::user()->following->contains($this->user);
        } else {
            $this->isFollowing = false;
            $this->anonymously = true;
        }
        $this->messages = $this->user->messages()->whereHas('replay')->get();
    }
    public function sendMessage()
    {
        $this->validate();
        $this->user->messages()->create([
            "message" => $this->message,
            "user_id" => Auth::id(),
            "is_anon" => $this->anonymously
        ]);
        $this->message = "";
    }

    public function follow()
    {
        if (Auth::check() == false) {
            $this->dispatch('not-auth-for-follow');
            return;
        }

        if ($this->isFollowing) {
            Auth::user()->following()->detach($this->user);
            $this->isFollowing = false;
            return;
        }
        Auth::user()->following()->attach($this->user);
        $this->isFollowing = true;
    }

    public function render()
    {
        return view('livewire.pages.profile.user-profile')->extends('components.layouts.app');
    }
}
