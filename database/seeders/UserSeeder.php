<?php

namespace Database\Seeders;

use App\Models\Message;
use App\Models\MessageReplay;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
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
