<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Message;
use App\Models\MessageFavourite;
use App\Models\MessageLike;
use Illuminate\Database\Seeder;

final class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Message::factory(100)->create();
        MessageFavourite::factory(100)->create();
        MessageLike::factory(100)->create();

    }
}
