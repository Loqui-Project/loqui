<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('search');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        $users = User::search($query)
            ->get();

        return response()->json(UserResource::collection($users));
    }
}
