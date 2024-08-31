<?php

declare(strict_types=1);

namespace App\Livewire\Pages;

use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

final class MessageShow extends Component
{
    public Message $message;

    public $hasReplay = false;

    public ?User $user = null;

    public function mount(int $id): void
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
