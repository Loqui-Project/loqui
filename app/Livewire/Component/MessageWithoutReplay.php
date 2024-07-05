<?php

namespace App\Livewire\Component;

use App\Jobs\NewReplayJob;
use App\Livewire\Pages\Inbox;
use App\Models\Message;
use App\Models\User;
use App\Notifications\NewReplayNotification;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Component;

class MessageWithoutReplay extends Component
{
    public Message $message;

    #[Validate('required|min:6')]
    public string $replay = '';

    public User $user;

    public User $authUser;

    public function mount(Message $message)
    {
        $this->message = $message;
        $this->user = $this->message->sender;
        $this->authUser = Auth::user();
    }

    public function addReplay()
    {
        $this->validate();
        $this->message->replay()->create([
            'text' => $this->replay,
            'user_id' => Auth::id(),
        ]);
        if ($this->user != null) {
            NewReplayJob::dispatch($this->user, $this->authUser, $this->message);
        }
        $this->dispatch('add-replay')->to(Inbox::class);
    }

    public function render()
    {
        return view('livewire.component.message-without-replay', [
            'message' => $this->message,
        ]);
    }
}
