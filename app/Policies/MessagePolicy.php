<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

final class MessagePolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Message $message): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return Auth::check();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Message $message): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Message $message): bool
    {
        return Auth::check() && $user->id === $message->user_id
            ? true
            : false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Message $message): bool
    {
        return false;
    }
}
