<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Inertia\Inertia;

final class SearchController extends Controller
{
    /**
     * Show the search page.
     */
    public function index(): \Inertia\Response
    {
        return Inertia::render('search');
    }

    /**
     * Search for users.
     */
    public function search(Request $request): \Illuminate\Http\JsonResponse
    {
        $query = type($request->input('query'))->asString();

        $users = Cache::remember("search.users.{$query}", 600, function () use ($query) {
            return User::search($query)
                ->get();
        }, 300);

        return response()->json(UserResource::collection($users));
    }
}
