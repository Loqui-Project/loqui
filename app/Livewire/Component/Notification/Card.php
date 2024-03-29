<?php

namespace App\Livewire\Component\Notification;

use App\Models\Notification;
use App\Models\NotificationTemplate;
use App\Models\User;
use App\NotificationTypeEnum;
use Carbon\Carbon;
use Livewire\Attributes\On;
use Livewire\Component;

class Card extends Component
{

    public Notification $notification;
    public NotificationTemplate $notificationTemplate;
    public string|null $url;
    public string $userImage;
    public string $senderName;
    public int $senderId;
    public string|null $senderUsername;
    public string $created_at;

    public function mount(Notification $notification)
    {

        $this->notification = $notification;
        $this->notificationTemplate = NotificationTemplate::where('type', $notification->type)->first();
        if ($this->notification->type == NotificationTypeEnum::NEW_MESSAGE->value) {
            $this->url = route('message.show', ['message' => $this->notification->data['message_id']]);
        } else {
            $this->url = "#";
        }
        if (in_array("message_id", $this->notification->data)) {
        }
        if ($notification->data['sender_id'] == null) {
            $this->userImage = asset('images/default-avatar.png');
            $this->senderId = 0;
            $this->senderName = str_replace(":sender", ' <strong class="dark:text-white">Anonymous</strong>',  $this->notificationTemplate->name);
            $this->senderUsername = null;
        } else {
            $sender = User::where('id', $notification->data['sender_id'])->first();
            $this->userImage = $sender->mediaObject->media_path;
            $this->senderName = str_replace(":sender", ' <strong class="dark:text-white">' . $sender->name . '</strong>',  $this->notificationTemplate->name);
            $this->senderId = $sender->id;
            $this->senderUsername = $sender->username;
        }
        $this->created_at = Carbon::parse($this->notification->created_at)->diffForHumans();
    }
    
    #[On("save")]
    public function refresh()
    {
        $this->mount($this->notification);
    }

    public function markAsRead()
    {
        $this->notification->markAsRead();
        $this->dispatch("save");
    }


    public function render()
    {
        return view('livewire.component.notification.card');
    }
}
