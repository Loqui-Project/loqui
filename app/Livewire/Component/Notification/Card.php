<?php

namespace App\Livewire\Component\Notification;

use App\Models\User;
use Illuminate\Notifications\DatabaseNotification;
use Livewire\Attributes\On;
use Livewire\Component;

class Card extends Component
{
    public $notification;

    public User $user;

    public User $fromUser;

    public $type = '';

    public $url = '';

    public function mount(DatabaseNotification $notification)
    {
        $this->notification = $notification;
        $this->user = User::where('id', $notification->notifiable_id)->first();
        $this->fromUser = User::where(
            'id',
            $notification->data['current_user_id'],
        )->first();
        $this->type = $notification->type;
        if ($this->type === 'new-message') {
            $this->url = route('message.show', [
                'id' => $notification->data['message_id'],
            ]);
        } elseif ($this->type === 'new-follow') {
            $this->url = route('profile.user', [
                'username' => $this->fromUser->username,
            ]);
        }
    }

    #[On('save')]
    public function refresh()
    {
        $this->mount($this->notification);
    }

    public function markAsRead()
    {
        $this->notification->markAsRead();
        $this->dispatch('save');
    }

    public function render()
    {
        return view('livewire.component.notification.card');
    }
}
