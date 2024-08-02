<?php

namespace App\Livewire\Pages;

use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class MessageShow extends Component
{
    public Message $message;

    public $hasReplay = false;

    public ?User $user = null;

    public function mount(int $id)
    {
        $this->message = Message::findOrFail($id);
        $this->hasReplay = $this->message->replay()->exists();
        $this->user = Auth::user();
    }

    public function render()
    {
        return view('livewire.pages.message-show');
    }
}
