<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MessageFavourite>
 */
final class MessageFavouriteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = \App\Models\User::inRandomOrder()->first();
        $message = \App\Models\Message::inRandomOrder()->first();

        return [
            'user_id' => $user?->id,
            'message_id' => $message?->id,
        ];
    }
}
