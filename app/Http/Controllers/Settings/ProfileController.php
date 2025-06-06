<?php

declare(strict_types=1);

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\ProfileUpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Exception;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Inertia\Inertia;
use Inertia\Response;

final class ProfileController extends Controller
{

    /**
     * Update the user's profile settings.
     */
    public function __invoke(ProfileUpdateRequest $request): JsonResponse
    {
        try {
            $user = type($request->user())->as(User::class);
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
