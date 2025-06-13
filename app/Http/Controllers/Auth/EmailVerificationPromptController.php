<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class EmailVerificationPromptController extends Controller
{
    /**
     * Show the email verification prompt page.
     */
    public function __invoke(Request $request): JsonResponse
    {
        /* @var User $user */
        $user = $request->user();

        if ($user === null) {
            return $this->responseFormatter->responseError('User not found.', 404);
        }

        return $user->hasVerifiedEmail()
            ? $this->responseFormatter->responseSuccess('Email verified.', [
                'is_verified' => true,
            ])
            : $this->responseFormatter->responseSuccess(
                'Please verify your email address.',
                [
                    'is_verified' => false,
                ]
            );
    }
}
