<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class EmailVerificationNotificationController extends Controller
{
    /**
     * Send a new email verification notification.
     */
    public function store(Request $request): JsonResponse
    {
        $user = type($request->user())->as(User::class);
        if ($user->hasVerifiedEmail()) {
            return $this->responseFormatter->responseError(
                message: 'Your email address is already verified.',
                code: 400
            );
        }

        $user->sendEmailVerificationNotification();

        return $this->responseFormatter->responseSuccess(
            message: 'Verification link sent to your email address.',
            data: [],
            code: 201
        );
    }
}
