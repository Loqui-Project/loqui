<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Message;
use App\Models\MessageReplay;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<MessageReplay>
 */
final class MessageReplayFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $message = Message::inRandomOrder()->first();

        return [
            'message_id' => $message?->id,
            'user_id' => $message?->user_id,
            'text' => fake()->text,
        ];
    }
}
