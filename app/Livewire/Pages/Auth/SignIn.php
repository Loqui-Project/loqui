<?php

namespace App\Livewire\Pages\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Component;

class SignIn extends Component
{
    #[Validate('required|min:3|email')]
    public string $email = '';

    #[Validate('required|min:6')]
    public string $password = '';

    public function signIn()
    {
        $this->validate();
        if (Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
            return redirect()->route('home');
        }
        $this->addError('email', 'Invalid email or password t.');
    }

    public function render()
    {
        return view('livewire.pages.auth.sign-in')->extends('components.layouts.guest');
    }
}
