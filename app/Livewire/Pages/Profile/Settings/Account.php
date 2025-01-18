<?php

declare(strict_types=1);

namespace App\Livewire\Pages\Profile\Settings;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;
use Masmerise\Toaster\Toastable;

final class Account extends Component
{
    use Toastable, WithFileUploads;

    public ?User $user;

    public $photo;

    public function rules(): array
    {
        return [
            'user.username' => 'nullable|min:5|max:30|unique:users,username,'.$this->user->id,
            'user.name' => 'required|min:5|max:50',
            'user.email' => 'required|email|unique:users,email,'.$this->user->id,
            'user.bio' => 'nullable|min:5|max:255',
            'photo' => 'nullable|image',
        ];
    }

    public function mount(): void
    {
        $this->user = Auth::user();
    }

    public function update(): void
    {
        try {
            $this->validate();
            if ($this->photo) {
                $this->user->photo = $this->user->store('users', 'public');
            }
            $this->user->save();
            $this->success('Profile updated successfully');
        } catch (Exception $e) {
            $this->error('Profile updated failed');
        }
    }

    #[Title('Account')]
    #[Layout('components.layouts.profile')]
    public function render()
    {
        return view('livewire.pages.profile.settings.account');
    }
}
