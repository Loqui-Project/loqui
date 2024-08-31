<?php

declare(strict_types=1);

namespace App\Livewire\Pages\Profile;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Component;

final class Favorite extends Component
{
    public ?User $user = null;

    public $favorites;

    public function mount(): void
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
