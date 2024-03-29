<?php

namespace App\Livewire\Component;

use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class MessageWithReplay extends Component
{
    public Message $message;

    public ?User $user;

    public int $likes = 0;

    public bool $liked = false;

    public int $favorites = 0;

    public bool $favorited = false;

    public function mount(Message $message)
    {
        $this->message = $message;
        $this->user = Auth::user();
        $this->likes = $this->message->likes->count();
        if (Auth::check()) {
            $this->liked = $this->message->likes->contains('user_id', $this->user->id);
            $this->favorited = $this->message->favorites->contains('user_id', $this->user->id);
        }
        $this->favorites = $this->message->favorites->count();
    }

    #[On('add-like')]
    public function refreshLikes()
    {
        $this->likes = $this->message->likes->count();
        $this->liked = $this->message->likes->contains('user_id', $this->user->id);
    }

    #[On('add-favorite')]
    public function refreshFavorites()
    {
        $this->favorites = $this->message->favorites->count();
        $this->favorited = $this->message->favorites->contains('user_id', $this->user->id);
    }

    public function addLike()
    {
        if ($this->liked) {
            $this->message->likes()->where('user_id', $this->user->id)->delete();
            $this->dispatch('add-like');

            return;
        }
        $this->message->likes()->create([
            'user_id' => $this->user->id,
        ]);
        $this->dispatch('add-like');

    }

    public function addFavorite()
    {
        if ($this->favorited) {
            $this->message->favorites()->where('user_id', $this->user->id)->delete();
            $this->dispatch('add-favorite');

            return;
        }
        $this->message->favorites()->create([
            'user_id' => $this->user->id,
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
        ]);
    }
}
