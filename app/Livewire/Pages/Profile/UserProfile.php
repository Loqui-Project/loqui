<?php

declare(strict_types=1);

namespace App\Livewire\Pages\Profile;

use App\Jobs\NewMessageJob;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

final class UserProfile extends Component
{
    public ?User $user = null;

    public $isModalOpen = false;

    public ?User $authUser = null;

    public bool $isFollowing = false;

    public bool $anonymously = false;

    public Collection $userMessages;

    public string $content = '';

    public function mount(User $user): void
    {
        $this->user = $user;
        $this->authUser = Auth::user();
        if ($this->authUser) {
            $this->isFollowing = $this->authUser->isFollowing($this->user);
        } else {
            $this->isFollowing = false;
            $this->anonymously = true;
        }
        $this->userMessages = $this->user
            ->messages()
            ->whereHas('replay')
            ->latest()
            ->get();
    }

    public function sendMessage(): void
    {
        $this->validate([
            'content' => 'required|min:1',
        ]);
        $message = $this->user->messages()->create([
            'message' => $this->content,
            'user_id' => $this->user->id,
            'sender_id' => $this->authUser instanceof User ? $this->authUser->id : null,
            'is_anon' => $this->anonymously,
        ]);
        NewMessageJob::dispatch($this->user, $this->authUser, $message);
        $this->content = '';
    }

    #[Layout('components.layouts.app')]
    public function render()
    {
        return view('livewire.pages.profile.user-profile')->title($this->user->username);
    }
}
