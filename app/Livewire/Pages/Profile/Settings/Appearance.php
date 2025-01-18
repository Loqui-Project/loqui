<?php

namespace App\Livewire\Pages\Profile\Settings;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class Appearance extends Component
{
    #[Title('Appearance')]
    #[Layout('components.layouts.profile')]
    public function render()
    {
        return view('livewire.pages.profile.settings.appearance');
    }
}
