<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\Handler;
use App\Http\Requests\API\CreateMediaObjectRequest;
use App\Models\MediaObject;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class MediaObjectController extends Handler
{
    /**
     * Create new media object
     */
    public function createMedia(CreateMediaObjectRequest $request): JsonResponse
    {
        try {
            $image = date('Y').'/'.date('m').'/'.random_int(500, 999) * time().'.'.$request->media->extension();
            /** @var \Illuminate\Contracts\Filesystem\Filesystem $publicStorage */
            Storage::putFileAs('public', $request->media, $image, 'public');
            $mediaImage = Image::make(public_path('storage/'.$image));

            $mediaObject = [
                'media_path' => 'storage/'.$image,
                'media_type' => 'image',
                'media_name' => $mediaImage->filename,
                'media_size' => $mediaImage->filesize(),
                'media_extension' => $mediaImage->extension,
                'media_mime_type' => $mediaImage->mime,
            ];
            $image = MediaObject::create($mediaObject);

            return $this->responseSuccess([
                'media' => $image,
            ], 201);
        } catch (\Throwable $th) {
            return $this->responseSuccess(null, 500);
        }
    }
}
