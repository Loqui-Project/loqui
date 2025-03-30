<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Middleware;

final class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<mixed>
     */
    public function share(Request $request): array
    {
        if (Auth::check() === true) {
            $authUser = type($request->user())->as(User::class);
            $user = $authUser->loadCount([
                'messages',
                'followers',
                'following',
            ]);
            $statistics = [
                'messages' => $user->messages_count,
                'followers' => $user->followers_count ?? 0,
                'following' => $user->following_count ?? 0,
            ];

            return array_merge(
                parent::share($request),
                [
                    'name' => config('app.name'),
                    'auth' => new UserResource($user),
                    'statistics' => $statistics,
                    'is_admin' => $user->hasRole('super-admin') || $user->hasRole('admin'),
                ]
            );
        }

        return array_merge(
            parent::share($request),
            [
                'name' => config('app.name'),
                'auth' => null,
            ]
        );

    }
}
