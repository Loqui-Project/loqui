<?php

namespace Database\Factories;

use App\Models\MediaObject;
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
        $mediaObject = MediaObject::first();
        if ($mediaObject == null) {
            $mediaObject = MediaObject::factory()->create();
        }
        $message = \App\Models\Message::inRandomOrder()->first();
        return [
            'message_id' => $message->id,
            'user_id' => $message->user_id,
            'text' => fake()->text,
            'media_object_id' => $mediaObject->id,
        ];
    }
}
