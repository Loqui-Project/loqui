<?php

declare(strict_types=1);

namespace App\Livewire\Pages\Password;

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;

final class Reset extends Component
{
    #[Validate('required|min:6|confirmed')]
    public string $password = '';

    #[Validate('required|min:6')]
    public string $password_confirmation;

    public bool $status = false;

    public string $message = '';

    public bool $show = false;

    public string $token = '';

    public string $email = '';

    public function mount()
    {
        $request = request();

        $this->token = $request->token;
        $this->email = $request->email;

        $this->show = false;
        $this->status = false;
        $this->message = false;

        $user = User::where('email', $this->email)->first();

        // check if token is valid
        $status = Password::tokenExists(
            $user,
            $this->token
        );
        if ($status === false) {
            return redirect()->route('auth.sign-in')->with('message', 'Invalid token')->with('show', true)->with('status', false);
        }

        return null;
    }

    public function resetPassword()
    {
        $this->validate();
        $status = Password::reset(
            [
                'email' => $this->email,
                'password' => $this->password,
                'password_confirmation' => $this->password,
                'token' => $this->token,
            ],
            function (User $user, string $password): void {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );
        if ($status === Password::PASSWORD_RESET) {
            $this->show = true;
            $this->message = 'Password reset successfully';
            $this->status = true;
            $this->password = '';
            $this->password_confirmation = '';

            return redirect()->route('auth.sign-in')->with('message', 'Password reset successfully')->with('show', true)->with('status', false);
        }
        $this->show = true;
        $this->message = 'Failed to reset password';
        $this->status = false;

        $this->password = '';
        $this->password_confirmation = '';

        return null;
    }

    #[Layout('components.layouts.guest')]
    #[Title('Reset Password')]
    public function render()
    {
        return view('livewire.pages.password.reset');
    }
}
