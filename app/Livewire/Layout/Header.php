<?php

namespace App\Livewire\Layout;

use App\Models\User;
use Livewire\Component;

class Header extends Component
{
    public ?User $user;

    public function mount(User $user)
    {
        $this->user = $user;
    }

    public function render()
    {
        return view('livewire.layout.header');
    }
}
