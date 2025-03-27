<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserFollow>
 */
final class UserFollowFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = \App\Models\User::inRandomOrder()->first();
        $follower = \App\Models\User::where('id', '!=', $user->id)->inRandomOrder()->first();

        return [
            'user_id' => $user?->id,
            'follower_id' => $follower?->id,
        ];
    }
}
