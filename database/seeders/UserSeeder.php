<?php

declare(strict_types=1);

namespace Database\Seeders;

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
            'email' => 'me@yanalshoubaki.com',
            'username' => 'yanalshoubaki',
            'name' => 'Yanal Shoubaki',
        ]);

        User::factory(10)->create();
        User::factory(10)->unverified()->create();
    }
}
