<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

final class EmailVerificationPromptController extends Controller
{
    /**
     * Show the email verification prompt page.
     */
    public function __invoke(Request $request): JsonResponse
    {
        $user = type($request->user())->as(User::class);

        return $user->hasVerifiedEmail()
            ?  $this->responseFormatter->responseSuccess('Email verified.', [
                'is_verified' => true
            ])
            : $this->responseFormatter->responseSuccess(
                'Please verify your email address.',
                [
                    'is_verified' => false,
                ]
            );
    }
}
