<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::factory()->create([
            'email' => 'me@yanalshoubaki.com',
            'username' => 'yanalshoubaki',
            'name' => 'Yanal Shoubaki',
        ]);
        $user->assignRole('super-admin');
    }
}
