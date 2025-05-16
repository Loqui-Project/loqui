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
        $query = $request->input('query');
        $users = Cache::remember("search.users.{$query}", 600, function () use ($query) {
            return User::search($query)
                ->get();
        }, 300);

        return $this->responseFormatter->responseSuccess('', [
            'users' => UserResource::collection($users),
        ]);
    }
}
