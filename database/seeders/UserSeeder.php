<?php

namespace Database\Seeders;

use App\Models\Message;
use App\Models\User;
use Illuminate\Database\Seeder;
use Intervention\Image\Facades\Image;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $defaultImage = public_path("images/default-avatar.png");
        $placeHolderImage = Image::make($defaultImage);
        // move image to storage
        $placeHolderImage->save(public_path('storage/'.$placeHolderImage->basename));
        $mediaObjectData = [
            'media_path' => 'storage/' .$placeHolderImage->basename,
        ];
        \App\Models\MediaObject::create($mediaObjectData);
        User::factory()->create([
            'email' => 'me@yanalshoubaki.com',
            'username' => 'yanalshoubaki',
            'name' => 'Yanal Shoubaki',
        ]);
        User::factory()->count(10)->has(Message::factory(), 'messages')->create();
    }
}
