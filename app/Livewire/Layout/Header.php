<?php

declare(strict_types=1);

namespace App\Livewire\Layout;

use App\Models\User;
use Livewire\Component;

final class Header extends Component
{
    public ?User $user = null;

    public function mount(User $user): void
    {
        $this->user = $user;
    }

    public function render()
    {
        return view('livewire.layout.header');
    }
}
