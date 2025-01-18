<?php

namespace App\Livewire\Pages\Profile\Settings;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Masmerise\Toaster\Toastable;

class Notification extends Component
{
    use Toastable;
    public ?User $user;
    public array $mail = [];

    public array $browser = [];

    public function mount()
    {
        $this->user = Auth::user();
        $notificationSettings = $this->user->notificationSettings()->get()->map(
            fn($item): array => [
                "type" => $item->type,
                "key" => $item->key,
                "value" => (bool) $item->value,
            ],
        );
        $this->mail = $notificationSettings
            ->where("type", "mail")
            ->pluck("value", "key")
            ->toArray();

        $this->browser = $notificationSettings
            ->where("type", "browser")
            ->pluck("value", "key")
            ->toArray();
    }

    public function update()
    {
        try {
            foreach ($this->mail as $key => $value) {
                $this->user->notificationSettings()->updateOrCreate(
                    [
                        "type" => "mail",
                        "key" => $key,
                    ],
                    [
                        "value" => (bool) $value,
                    ],
                );
            }
            foreach ($this->browser as $key => $value) {
                $this->user->notificationSettings()->updateOrCreate(
                    [
                        "type" => "browser",
                        "key" => $key,
                    ],
                    [
                        "value" => (bool) $value,
                    ],
                );
            }
            $this->success("Notification settings updated successfully");
        } catch (\Throwable $th) {
            $this->error("Notification settings update failed");
        }
    }

    #[Title("Notification")]
    #[Layout("components.layouts.profile")]
    public function render()
    {
        return view("livewire.pages.profile.settings.notification");
    }
}
