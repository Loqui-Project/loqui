<?php

namespace App\Livewire\Pages;

use App\Models\Message;
use Livewire\Component;

class MessageShow extends Component
{

    public Message $message;

    public function mount(Message $message)
    {
        $this->message = $message;
    }

    public function render()
    {
        return view('livewire.pages.message-show')->extends('components.layouts.app');
    }
}
