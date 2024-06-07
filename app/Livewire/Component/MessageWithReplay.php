<?php

namespace App\Livewire\Component;

use App\Models\Message;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\On;
use Livewire\Component;

class MessageWithReplay extends Component
{
    public Message $message;

    public ?User $authUser = null;

    public Collection $likes;

    public Collection $favorites;

    public int $likes_count = 0;

    public bool $liked = false;

    public int $favorites_count = 0;

    public bool $favorited = false;

    public $usersLike;

    public $messageDetails = [];

    public function mount(Message $message)
    {
        $this->message = $message;
        $this->authUser = Cache::remember('user:' . Auth::id(), now()->addHours(4), function () {
            return Auth::user();
        });
        $this->likes = Cache::remember("message:{$message->id}:likes", now()->addHours(4), function () {
            return $this->message->likes;
        });
        $this->favorites = Cache::remember("message:{$message->id}:favorites", now()->addHours(4), function () {
            return $this->message->favorites;
        });
        $this->likes_count = $this->likes->count();
        $this->favorites_count = $this->favorites->count();
        if ($this->authUser) {
            $this->liked = $this->message->likes->contains('user_id', $this->authUser->id);
            $this->favorited = $this->message->favorites->contains('user_id', $this->authUser->id);
        }
        $this->messageDetails = [
            'title' => $this->message->message,
            'url' => route('message.show', ['message' => $this->message]),
        ];
    }

    #[On('add-like')]
    public function refreshLikes()
    {
        Cache::forget("message:{$this->message->id}:likes");

        $this->likes = Cache::remember("message:{$this->message->id}:likes", now()->addHours(4), function () {
            return $this->message->likes;
        });

        $this->liked = $this->message->likes->contains('user_id', $this->authUser->id);
        $this->likes_count = $this->likes->count();
    }

    #[On('add-favorite')]
    public function refreshFavorites()
    {
        Cache::flush();
        $this->favorites = Cache::remember("message:{$this->message->id}:favorites", now()->addHours(4), function () {
            return $this->message->favorites;
        });
        $this->favorited = $this->message->favorites->contains('user_id', $this->authUser->id);
        $this->favorites_count = $this->favorites->count();
    }

    public function addLike()
    {
        if ($this->liked) {
            $this->message->likes()->where('user_id', $this->authUser->id)->delete();
            $this->dispatch('add-like');

            return;
        }
        $this->message->likes()->create([
            'user_id' => $this->authUser->id,
        ]);
        $this->dispatch('add-like');
    }

    public function addFavorite()
    {
        if ($this->favorited) {
            $this->message->favorites()->where('user_id', $this->authUser->id)->delete();
            $this->dispatch('add-favorite');

            return;
        }
        $this->message->favorites()->create([
            'user_id' => $this->authUser->id,
        ]);
        $this->dispatch('add-favorite');
    }

    public function render()
    {
        return view('livewire.component.message-with-replay', [
            'message' => $this->message,
            'likes' => $this->likes,
            'liked' => $this->liked,
            'favorites' => $this->favorites,
            'favorited' => $this->favorited,
            'likes_count' => $this->likes_count,
            'favorites_count' => $this->favorites_count,
            'message_details' => $this->messageDetails,
        ]);
    }
}
