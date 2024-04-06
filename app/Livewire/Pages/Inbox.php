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

    public int $perPage = 10;

    public function mount()
    {
        if (! Auth::check()) {
            return redirect()->route('auth.sign-in');
        }
        $this->perPage = 10;
    }

    #[On('add-replay')]
    public function refreshMessages()
    {
        $id = Auth::id();
        Cache::driver('redis')->forget("user:{$id}:messages:without_replay");
    }

    #[On('load-more')]
    public function loadMore()
    {
        $this->perPage = $this->perPage + 10;
    }

    #[Computed]
    public function userMessages()
    {
        $key = 'user:'.auth()->id().":messages:without_replay:{$this->perPage}";
        $seconds = 3600 * 6; // 1 hour...

        return Cache::remember(
            $key,
            $seconds,
            function () {
                return Message::where('user_id', Auth::id())
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
        $key = 'user:'.auth()->id().':messages:without_replay:count';
        $seconds = 3600 * 6; // 1 hour...

        return Cache::remember(
            $key,
            $seconds,
            function () {
                return Message::where('user_id', Auth::id())
                    ->doesntHave('replay')
                    ->count();
            }
        );
    }

    public function render()
    {
        $user = Auth::user();

        return view('livewire.pages.inbox', [
            'userMessages' => $this->userMessages(),
            'messageCount' => $this->userMessagesCount(),
            'user' => $user,
        ])->extends('components.layouts.app');
    }
}
