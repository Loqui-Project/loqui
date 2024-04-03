<?php

namespace Database\Seeders;

use App\Models\NotificationTemplate;
use App\NotificationTypeEnum;
use Illuminate\Database\Seeder;

class NotificationTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        NotificationTemplate::create([
            'type' => NotificationTypeEnum::NEW_FOLLOWER,
            'name' => ':sender followed you',
            'subject' => ':sender followed you',
            'body' => ':sender followed you',
        ]);

        NotificationTemplate::create([
            'type' => NotificationTypeEnum::NEW_MESSAGE,
            'name' => ':sender sent you a message',
            'subject' => ':sender sent you a message',
            'body' => ':sender sent you a message',
        ]);
    }
}
