<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MessageReplay>
 */
class MessageReplayFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $message = \App\Models\Message::inRandomOrder()->first();

        return [
            'message_id' => $message?->id,
            'user_id' => $message?->user_id,
            'text' => fake()->text,
        ];
    }
}
