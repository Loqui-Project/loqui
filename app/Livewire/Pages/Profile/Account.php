<?php

declare(strict_types=1);

namespace App\Livewire\Pages\Profile;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

final class Account extends Component
{
    use WithFileUploads;

    public User $user;

    public $name;

    public $email;

    public $password;

    public $password_confirmation;

    public $username;

    public $photo;

    public array $mail = [];

    public array $browser = [];

    public string $bio = '';

    public function rules(): array
    {
        return [
            'photo' => 'nullable|image',
            'username' => 'nullable|min:5|max:30|unique:users,username,'.
                $this->user->id,
            'name' => 'required|min:5|max:50',
            'email' => 'required|email|unique:users,email,'.$this->user->id,
            'password' => 'nullable|min:8|max:20|confirmed',
            'mail.*' => 'boolean',
            'browser.*' => 'boolean',
            'bio' => 'nullable|min:5|max:255',
        ];
    }

    public function mount(): void
    {
        $this->user = Auth::user();
        $this->name = $this->user->name;
        $this->email = $this->user->email;
        $this->username = $this->user->username;
        $notificationSettings = $this->user
            ->notificationSettings()
            ->get()
            ->map(fn ($item): array => [
                'type' => $item->type,
                'key' => $item->key,
                'value' => (bool) $item->value,
            ]);
        $this->mail = $notificationSettings
            ->where('type', 'mail')
            ->pluck('value', 'key')
            ->toArray();

        $this->browser = $notificationSettings
            ->where('type', 'browser')
            ->pluck('value', 'key')
            ->toArray();
    }

    public function updateProfile(): void
    {
        $this->validate();
        $this->user->name = $this->name;
        $this->user->email = $this->email;
        $this->user->username = $this->username;
        $this->user->bio = $this->bio;
        if ($this->photo) {
            $hashedImageName =
                'image_'.
                Carbon::now()->timestamp.
                '.'.
                $this->photo->getClientOriginalExtension();
            $placeHolderImage = $this->photo->storePubliclyAs(
                'photos',
                $hashedImageName,
                [
                    'disk' => 'public',
                ],
            );
            $this->user->image_url = 'storage/'.$placeHolderImage;
        }

        if ($this->password) {
            $this->user->password = Hash::make($this->password);
        }

        $this->user->save();
        foreach ($this->mail as $key => $value) {
            $this->user->notificationSettings()->updateOrCreate(
                [
                    'type' => 'mail',
                    'key' => $key,
                ],
                [
                    'value' => (bool) $value,
                ],
            );
        }
        foreach ($this->browser as $key => $value) {
            $this->user->notificationSettings()->updateOrCreate(
                [
                    'type' => 'browser',
                    'key' => $key,
                ],
                [
                    'value' => (bool) $value,
                ],
            );
        }
    }

    #[Title('Account')]
    public function render()
    {
        return view('livewire.pages.profile.account', [
            'user' => $this->user,
        ]);
    }
}
