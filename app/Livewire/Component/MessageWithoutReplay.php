<?php

namespace App\Livewire\Component;

use App\Livewire\Pages\Inbox;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Component;

class MessageWithoutReplay extends Component
{
    public Message $message;

    #[Validate('required|min:6')]
    public string $replay = '';

    public function mount(Message $message)
    {
        $this->message = $message;
    }

    public function addReplay()
    {
        $this->validate();
        $this->message->replay()->create([
            'text' => $this->replay,
            'user_id' => Auth::id(),
        ]);
        $this->dispatch('add-replay')->to(Inbox::class);
    }

    public function render()
    {
        return view('livewire.component.message-without-replay', [
            'message' => $this->message,
        ]);
    }
}
