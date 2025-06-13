<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

final class SearchController extends Controller
{
    /**
     * Search for users.
     */
    public function __invoke(Request $request): JsonResponse
    {
        $query = type($request->query->get('query'))->asString();
        if (empty($query)) {
            return $this->responseFormatter->responseError('Query cannot be empty', 400);
        }

        /* @var User $authUser */
        $authUser = $request->user();
        $users = Cache::remember("search.users.{$query}", 600, function () use ($query, $authUser) {
            return User::search($query)->get()->when($authUser !== null, function ($users) use ($authUser) {
                return $users->filter(fn (User $user) => $user->id !== $authUser?->id);
            });
        });

        return $this->responseFormatter->responseSuccess('', ['users' => UserResource::collection($users)]);
    }
}
