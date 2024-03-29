<?php

namespace App\Livewire\Pages\Auth;

use App\Models\MediaObject;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Validate;
use Livewire\Component;

class SignUp extends Component
{
    #[Validate('required|min:3')]
    public string $name;

    #[Validate('required|min:3|unique:users,username')]
    public string $username;

    #[Validate('required|min:3|email|unique:users,email')]
    public string $email;

    #[Validate('required|min:6|confirmed')]
    public string $password;

    #[Validate('required|min:6')]
    public string $password_confirmation;

    public function signUp()
    {
        $this->validate();
        try {
            $defaultImage = MediaObject::first();
            $user = User::create([
                'name' => $this->name,
                'username' => $this->username,
                'email' => $this->email,
                'password' => Hash::make($this->password),
                'media_object_id' => $defaultImage->id,
            ]);
            Auth::login($user);

            return redirect()->route('home');
        } catch (\Throwable $th) {
            $this->addError('email', $th->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.pages.auth.sign-up')->extends('components.layouts.guest');
    }
}
