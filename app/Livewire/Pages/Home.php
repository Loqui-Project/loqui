<?php

namespace App\Livewire\Pages;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Computed;
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

        $this->authUser = Cache::tags(['user:'.Auth::id()])->remember('user:'.Auth::id(), now()->addHours(5), function () {
            return User::where('id', Auth::id())->with(['followers', 'following', 'messages', 'mediaObject'])->withCount([
                'followers',
                'following',
                'messages',
            ])->first();
        });
        $this->userData = Cache::remember('user_data'.Auth::id(), now()->addHours(5), function () {
            return [
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
        });
    }

    public function loadMore()
    {
        $this->perPage = $this->perPage + 4;
    }

    #[Computed]
    public function userMessages()
    {

        $key = "user:{$this->authUser->id}:messages:with_replay:{$this->perPage}";
        $seconds = now()->addHours(5); // 1 hour...

        return Cache::tags(["user:{$this->authUser->id}:messages:without_replay"])->remember(
            $key,
            $seconds,
            function () {
                return $this->authUser->messages()->whereHas('replay')->with(['replay', 'user.mediaObject', 'sender.mediaObject', 'likes', 'favorites'])->whereIn('user_id', collect([$this->authUser->id])->merge($this->authUser->following->pluck('id')))->paginate($this->perPage);
            }
        );
    }

    public function render()
    {
        return view('livewire.pages.home', [
            'user' => $this->authUser,
            'messages' => $this->userMessages(),
        ])->extends('components.layouts.app');
    }
}
