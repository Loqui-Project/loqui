<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Message;
use App\Models\MessageReplay;
use App\Models\User;
use Illuminate\Database\Seeder;

final class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'email' => 'admin@example.com',
            'username' => 'admin',
            'name' => 'admin',
        ]);
        User::factory()->count(10)->has(Message::factory(), 'messages')->create();
        User::factory()->count(10)->has(Message::factory()->has(MessageReplay::factory(), 'replay'), 'messages')->create();
    }
}
