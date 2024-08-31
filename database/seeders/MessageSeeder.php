<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Message;
use Illuminate\Database\Seeder;

final class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Message::factory()->count(10)->create();
    }
}
