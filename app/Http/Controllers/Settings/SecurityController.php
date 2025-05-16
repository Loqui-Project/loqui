<?php

declare(strict_types=1);

namespace App\Http\Controllers\Settings;

use App\Enums\SocialProvidersEnum;
use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Response;

final class SecurityController extends Controller
{
    /**
     * Show the user's profile settings page.
     */
    public function edit(Request $request): JsonResponse
    {
        $user = type($request->user())->as(User::class);
        $socialConnections = $user->socialConnections()->get();

        $socialConnections = collect(SocialProvidersEnum::cases())->map(fn (SocialProvidersEnum $provider): array => [
            'provider' => $provider->value,
            'provider_name' => $provider->value,
            'connected' => $socialConnections->contains('provider', $provider->value),
        ]);

        return $this->responseFormatter->responseSuccess(
            'Security settings retrieved successfully.',
            [
                'socialConnections' => $socialConnections,
            ]
        );

    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'password' => ['required', 'current_password'],
            ]);

            $user = type($request->user())->as(User::class);

            $request->user()->token()->revoke();

            $user->delete();

            return $this->responseFormatter->responseSuccess(
                'Account deleted successfully.',
                [
                    'message' => 'Your account has been deleted.',
                ]
            );
        } catch (Exception $e) {
            return $this->responseFormatter->responseError($e->getMessage(), 422);
        }
    }

    public function deactivate(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'password' => ['required', 'current_password'],
            ]);

            $user = type($request->user())->as(User::class);

            $request->user()->token()->revoke();

            $user->deactivate();


            return $this->responseFormatter->responseSuccess(
                'Account deactivated successfully.',
                [
                    'message' => 'Your account has been deactivated.',
                ]
            );
        } catch (Exception $e) {
            return $this->responseFormatter->responseError($e->getMessage(), 422);
        }
    }
}
