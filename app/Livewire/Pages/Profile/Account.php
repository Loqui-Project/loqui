<?php

namespace App\Livewire\Pages\Profile;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;

class Account extends Component
{
    use WithFileUploads;

    public $user;

    public $name;

    public $email;

    public $password;

    public $password_confirmation;

    public $username;

    public $photo;

    public function rules()
    {
        return [
            'photo' => 'nullable|image|max:1024',
            'username' => 'nullable|min:5|max:15|unique:users,username,' . $this->user->id,
            'name' => 'required|min:5|max:50',
            'email' => 'required|email|unique:users,email,' . $this->user->id,
            'password' => 'nullable|min:8|max:20|confirmed',
        ];
    }
    public function mount()
    {
        $this->user = Auth::user();
        $this->name = $this->user->name;
        $this->email = $this->user->email;
        $this->username = $this->user->username;
    }

    public function updateProfile()
    {
        $this->validate();

        $this->user->name = $this->name;
        $this->user->email = $this->email;
        $this->user->username = $this->username;

        if ($this->password) {
            $this->user->password = Hash::make($this->password);
        }

        $this->user->save();
    }

    public function render()
    {
        return view('livewire.pages.profile.account', [
            'user' => $this->user
        ])->extends('components.layouts.app');
    }
}
