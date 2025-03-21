<?php

declare(strict_types=1);

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Inertia\Inertia;
use Inertia\Response;

final class ProfileController extends Controller
{
    /**
     * Show the user's profile settings page.
     */
    public function edit(Request $request): Response
    {
        return Inertia::render('settings/profile');
    }

    /**
     * Update the user's profile settings.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
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

        return to_route('profile.edit');
    }
}
