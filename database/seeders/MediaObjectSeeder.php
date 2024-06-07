<?php

namespace Database\Seeders;

use App\Models\MediaObject;
use Illuminate\Database\Seeder;

class MediaObjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MediaObject::factory()->create();
    }
}
