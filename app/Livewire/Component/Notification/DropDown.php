<?php

namespace App\Livewire\Component\Notification;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class DropDown extends Component
{
    public Collection $notifications;

    public User|null $user = null;
    public $count = 0;
    public function mount()
    {
        $this->user = Auth::user();
        $this->notifications = $this->user->notifications()->orderBy("created_at", "desc")->limit(5)->get();
        $this->count = $this->user->notifications()->whereNull("read_at")->count();
    }


    public function getListeners()
    {
        return [
            "echo-private:App.Models.User.{$this->user->id},NewMessageEvent" => 'refresh',
        ];
    }

    public function refresh()
    {
        $this->notifications = $this->user->notifications()->orderBy("created_at", "desc")->limit(5)->get();
        $this->count = $this->user->notifications()->whereNull("read_at")->count();
    }

    public function render()
    {
        return view('livewire.component.notification.drop-down');
    }
}
