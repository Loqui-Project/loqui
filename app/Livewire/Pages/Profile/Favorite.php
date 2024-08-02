<?php

namespace App\Livewire\Pages\Profile;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Component;

class Favorite extends Component
{
    public ?User $user;

    public $favorites;

    public function mount()
    {
        $this->user = Auth::user();
        $this->favorites = $this->user->favoriteMessages;
    }

    #[Title('Favorites')]
    public function render()
    {
        return view('livewire.pages.profile.favorite', [
            'favorites' => $this->favorites,
        ]);
    }
}
