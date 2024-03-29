<?php

namespace Database\Seeders;

use App\Models\NotificationTemplate;
use App\NotificationTypeEnum;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NotificationTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        NotificationTemplate::create([
            'type' => NotificationTypeEnum::NEW_MESSAGE,
            'name' => 'New Message from :sender',
            'subject' => 'New Message from :sender',
            'body' => 'You have a new message from :sender',
        ]);
    }
}
