<?php

namespace App\Livewire\Pages;

use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class Inbox extends Component
{
    use WithoutUrlPagination, WithPagination;

    public int $perPage = 4;

    public $authUser;

    public function mount()
    {
        $this->authUser = Auth::user();
        if (!$this->authUser) {
            return redirect()->route('auth.sign-in');
        }
        $this->perPage = 4;
    }

    #[On('add-replay')]
    public function refreshMessages()
    {
        Cache::tags(["user:{$this->authUser->id}:messages:without_replay"])->flush();
        $this->userMessages();
    }

    public function loadMore()
    {
        $this->perPage = $this->perPage + 4;
    }

    #[Computed]
    public function userMessages()
    {

        $key = "user:{$this->authUser->id}:messages:without_replay:{$this->perPage}";
        $seconds = 3600 * 6; // 1 hour...

        return Cache::tags(["user:{$this->authUser->id}:messages:without_replay"])->remember(
            $key,
            $seconds,
            function () {
                return Message::where('user_id', $this->authUser->id)
                    ->doesntHave('replay')
                    ->with('replay')
                    ->orderBy('created_at', 'desc')
                    ->paginate($this->perPage);
            }
        );
    }

    #[Computed]
    public function userMessagesCount()
    {
        $key = "user:{$this->authUser->id}:messages:without_replay:count";
        $seconds = 3600 * 6; // 1 hour...

        return Cache::remember(
            $key,
            $seconds,
            function () {
                return Message::where('user_id', $this->authUser->id)
                    ->doesntHave('replay')
                    ->count();
            }
        );
    }

    public function render()
    {
        return view('livewire.pages.inbox', [
            'userMessages' => $this->userMessages(),
            'messageCount' => $this->userMessagesCount(),
            'user' => $this->authUser,
        ])->extends('components.layouts.app');
    }
}
