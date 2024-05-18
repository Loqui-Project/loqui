<?php

namespace App\Livewire\Pages\Profile;

use App\Jobs\NewFollowerJob;
use App\Jobs\NewMessageJob;
use App\Models\User;
use App\Models\UserFollow;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
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
        $this->userMessages = Cache::remember("user:{$this->user->id}:messages:with_replay", now()->addHours(4), function () {
            return $this->user->messages()->whereHas('replay')->latest()->get();
        });
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
            UserFollow::where([
                'follower_id' => $this->authUser->id,
                'following_id' => $this->user->id,
            ])->delete();
            $this->isFollowing = false;
        } else {

            UserFollow::create([
                'follower_id' => $this->authUser->id,
                'following_id' => $this->user->id,
            ]);
            $this->isFollowing = true;
            NewFollowerJob::dispatch($this->user, $this->authUser);
        }
    }

    public function render()
    {
        return view('livewire.pages.profile.user-profile')->extends('components.layouts.app');
    }
}
