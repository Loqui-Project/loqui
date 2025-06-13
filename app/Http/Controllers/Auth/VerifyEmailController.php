<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\JsonResponse;

final class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request): JsonResponse
    {
        /* @var User $user */
        $user = $request->user();

        if ($user === null) {
            return $this->responseFormatter->responseError('User not found.', 404);
        }
        if ($user->hasVerifiedEmail()) {
            return $this->responseFormatter->responseError(message: 'Your email address is already verified.', code: 400);
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        return $this->responseFormatter->responseSuccess(message: 'Email address verified successfully.');
    }
}
