<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

final class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request): JsonResponse
    {
        $user = type($request->user())->as(User::class);
        if ($user->hasVerifiedEmail()) {
            return $this->responseFormatter->responseError(
                message: 'Your email address is already verified.',
                code: 400
            );
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        return $this->responseFormatter->responseSuccess(
            message: 'Email address verified successfully.',
            data: [],
            code: 200
        );
    }
}
