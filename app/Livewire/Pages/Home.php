<?php

namespace App\Livewire\Pages;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class Home extends Component
{
    use WithoutUrlPagination, WithPagination;

    public int $perPage = 4;

    public User $authUser;

    public array $userData = [];

    public function mount()
    {
        if (! Auth::check()) {
            return redirect()->route('auth.sign-in');
        }

        $this->authUser = User::where('id', Auth::id())->with(['followers', 'following', 'messages', 'mediaObject'])->withCount([
            'followers',
            'following',
            'messages',
        ])->first();
        $this->userData = [
            'followers' => [
                'count' => $this->authUser->followers_count,
                'data' => $this->authUser->followers->take(5),
            ],
            'following' => [
                'count' => $this->authUser->following_count,
                'data' => $this->authUser->following->take(5),
            ],
            'messages' => $this->authUser->messages_count,
        ];
    }

    public function loadMore()
    {
        $this->perPage = $this->perPage + 4;
    }

    public function userMessages()
    {
        return $this->authUser->messages()->whereHas('replay')->with(['replay', 'likes', 'favorites'])->whereIn('user_id', collect([$this->authUser->id])->merge($this->authUser->following->pluck('id')))->paginate($this->perPage);
    }

    public function render()
    {
        return view('livewire.pages.home', [
            'user' => $this->authUser,
            'messages' => $this->userMessages(),
            'user_data' => $this->userData,
        ])->extends('components.layouts.app');
    }
}
