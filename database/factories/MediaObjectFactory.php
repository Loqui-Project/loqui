<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MediaObject>
 */
class MediaObjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $defaultImage = public_path('images/default-avatar.png');
        $image = (new UploadedFile($defaultImage, 'default-avatar.png'));
        $hashedImageName = 'image_'.Carbon::now()->timestamp.'.'.$image->getClientOriginalExtension();

        // move image to storage
        $placeHolderImage = $image->storePubliclyAs('photos', $hashedImageName, [
            'disk' => 'public',
        ]);

        return [
            'media_path' => 'storage/'.$placeHolderImage,
        ];
    }
}
