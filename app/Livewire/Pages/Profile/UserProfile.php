<?php

namespace App\Livewire\Pages\Profile;

use App\Models\User;
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

    public function mount(User $user)
    {
        $this->user = $user;
        if ($this->user === null) {
            abort(404);
        }
        $this->authUser = Auth::user();
        if ($this->authUser) {
            $this->isFollowing = $this->authUser->isFollowing($this->user);
        } else {
            $this->isFollowing = false;
            $this->anonymously = true;
        }
        $this->userMessages = Cache::remember(
            "user:{$this->user->id}:messages:with_replay",
            now()->addHours(4),
            function () {
                return $this->user
                    ->messages()
                    ->whereHas('replay')
                    ->latest()
                    ->get();
            },
        );
    }

    public function sendMessage()
    {
        $this->validate([
            'content' => 'required|min:1',
        ]);
        $this->user->messages()->create([
            'message' => $this->content,
            'user_id' => $this->user->id,
            'sender_id' => $this->authUser ? $this->authUser->id : null,
            'is_anon' => $this->anonymously,
        ]);
        NewMessageJob::dispatch($this->user, $this->authUser, $message);
        $this->content = '';
    }

    public function follow()
    {
        if (! $this->authUser) {
            $this->dispatch('not-auth-for-follow');

            return;
        }
        if ($this->isFollowing) {
            $this->authUser->unfollowUser($this->user, $this->authUser);
            NewFollowerJob::dispatch($this->user, $this->authUser);
            $this->isFollowing = false;
        } else {
            $this->authUser->followUser($this->user, $this->authUser);
            NewFollowerJob::dispatch($this->user, $this->authUser);
            $this->isFollowing = true;
        }
    }

    public function render()
    {
        return view('livewire.pages.profile.user-profile')->extends(
            'components.layouts.app',
        );
    }
}
