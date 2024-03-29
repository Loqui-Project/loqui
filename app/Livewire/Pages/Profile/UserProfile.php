<?php

namespace App\Livewire\Pages\Profile;

use App\Jobs\NewMessageJob;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class UserProfile extends Component
{
    public ?User $user;

    public ?User $authUser = null;

    public bool $isFollowing = false;

    public bool $anonymously = false;

    public Collection $userMessages;

    public string $content = '';

    public function mount($username)
    {
        $this->user = User::where('username', $username)->first();
        $this->authUser = Auth::user();
        if ($this->authUser) {
            $this->isFollowing = $this->authUser->following->contains($this->user);
        } else {
            $this->isFollowing = false;
            $this->anonymously = true;
        }
        $this->userMessages = $this->user->messages()->whereHas('replay')->latest()->get();
    }

    public function sendMessage()
    {
        $this->validate([
            'content' => 'required|min:1',
        ]);
        $message = $this->user->messages()->create([
            'message' => $this->content,
            'user_id' => $this->user->id,
            'sender_id' => $this->authUser ? $this->authUser->id : null,
            'is_anon' => $this->anonymously,
        ]);
        NewMessageJob::dispatch($message);
        $this->content = '';
    }

    public function follow()
    {
        if (! $this->authUser) {
            $this->dispatch('not-auth-for-follow');

            return;
        }

        if ($this->isFollowing) {
            $this->authUser->following()->detach($this->user);
            $this->isFollowing = false;

            return;
        }
        $this->authUser->following()->attach($this->user);
        $this->isFollowing = true;
    }

    public function render()
    {
        return view('livewire.pages.profile.user-profile')->extends('components.layouts.app');
    }
}
