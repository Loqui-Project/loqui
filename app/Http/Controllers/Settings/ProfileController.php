<?php

declare(strict_types=1);

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\ProfileUpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\UploadedFile;

final class ProfileController extends Controller
{
    /**
     * Update the user's profile settings.
     */
    public function __invoke(ProfileUpdateRequest $request): JsonResponse
    {
        try {
            /* @var User $user */
            $user = $request->user();

            if ($user === null) {
                return $this->responseFormatter->responseError('User not found.', 404);
            }
            $inputs = $request->validated();
            $image = $request->file('image');
            if ($image) {
                $inputs['image_url'] = type($image)->as(UploadedFile::class)->store('images', 'public');
                unset($inputs['image']);
            }

            $user->fill($inputs);

            if ($user->isDirty('email')) {
                $user->sendEmailVerificationNotification();
                $user->email_verified_at = null;
            }

            $user->save();

            return $this->responseFormatter->responseSuccess(
                'Profile updated successfully.',
                [
                    'user' => new UserResource($user),
                ]
            );
        } catch (Exception $e) {
            return $this->responseFormatter->responseError($e->getMessage(), 422);
        }
    }
}
