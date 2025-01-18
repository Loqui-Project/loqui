<?php

namespace App\Livewire\Pages\Profile\Settings;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class Security extends Component
{
    #[Title('Security')]
    #[Layout('components.layouts.profile')]
    public function render()
    {
        return view('livewire.pages.profile.settings.security');
    }
}
