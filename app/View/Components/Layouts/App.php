<?php

namespace App\View\Components\Layouts;

use App\Models\User;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class App extends Component
{
    public User $user;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->user = User::where('id', Auth::id())->first() ?? null;
        dd($this->user);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        dd($this->user);

        return view('components.layouts.app');
    }
}
