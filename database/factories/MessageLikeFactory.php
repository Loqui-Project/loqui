<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Message;
use App\Models\MessageLike;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<MessageLike>
 */
final class MessageLikeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = User::inRandomOrder()->first();
        $message = Message::inRandomOrder()->first();

        return [
            'user_id' => $user?->id,
            'message_id' => $message?->id,
        ];
    }
}
