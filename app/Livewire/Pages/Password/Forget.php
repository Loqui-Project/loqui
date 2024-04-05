<?php

namespace App\Livewire\Pages\Password;

use Illuminate\Support\Facades\Password;
use Livewire\Component;
use Livewire\Attributes\Validate;

class Forget extends Component
{

    #[Validate('required|min:6|email')]
    public string $email = "";

    public bool $status = false;

    public string $message = "";

    public bool $show = false;


    public function mount()
    {
        $this->show = false;
    }

    public function forget()
    {
        $this->validate();

        $status = Password::sendResetLink(
            [
                'email' => $this->email
            ]
        );

        if ($status === Password::RESET_LINK_SENT) {
            $this->show = true;
            $this->email = '';
            $this->message = "Password reset link sent to your email";
            $this->status = true;
        } else {
            $this->show = true;
            $this->message = "Failed to send password reset link to your email";
            $this->status = false;
        }
    }

    public function render()
    {
        return view('livewire.pages.password.forget')->extends('components.layouts.guest');
    }
}
