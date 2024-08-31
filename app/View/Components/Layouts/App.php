<?php

declare(strict_types=1);

namespace App\View\Components\Layouts;

use App\Models\User;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

final class App extends Component
{
    public User $user;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->user = User::where('id', Auth::id())->first();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.layouts.app');
    }
}
