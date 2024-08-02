<?php

namespace App\Livewire\Pages\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;

class SignIn extends Component
{
    #[Validate('required|min:3|email')]
    public string $email = '';

    #[Validate('required|min:6')]
    public string $password = '';

    public bool $status = false;

    public string $message = '';

    public bool $show = false;

    public function mount()
    {
        $this->show = session('show') ?? false;
        $this->status = session('status') ?? false;
        $this->message = session('message') ?? '';
    }

    public function signIn()
    {
        $this->validate();
        if (Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
            return redirect()->route('home');
        }
        $this->addError('email', 'Invalid email or password.');
    }

    #[Layout('components.layouts.guest')]
    #[Title('Sign in')]
    public function render()
    {
        return view('livewire.pages.auth.sign-in');
    }
}
