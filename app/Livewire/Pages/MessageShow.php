<?php

namespace App\Livewire\Pages;

use App\Models\Message;
use Livewire\Component;

class MessageShow extends Component
{
    public Message $message;

    public $hasReplay = false;

    public function mount(Message $message)
    {
        $this->message = $message;
        $this->hasReplay = $message->replay()->exists();
    }

    public function render()
    {
        return view('livewire.pages.message-show')->extends('components.layouts.app');
    }
}
