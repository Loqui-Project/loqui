<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Message>
 */
final class MessageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = \App\Models\User::inRandomOrder()->first();
        $sender = \App\Models\User::inRandomOrder()->where('id', '!=', $user?->id)->first();

        return [
            'user_id' => $user?->id,
            'sender_id' => $sender?->id,
            'message' => $this->faker->text(200),
            'is_anon' => $this->faker->boolean(),
        ];
    }
}
