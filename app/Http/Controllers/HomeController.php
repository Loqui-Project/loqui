<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\MessageResource;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

final class HomeController extends Controller
{
    public function __invoke(Request $request): \Inertia\Response|\Illuminate\Http\JsonResponse
    {
        $user = type($request->user())->as(User::class);
        $followingUsersId = collect($user->followings()->get())->pluck('user_id')->flatten();
        $messages = Message::whereIn('user_id', [
            ...$followingUsersId,
            $user->id,
        ])->withReplies()->latest()->paginate();

        if (request()->wantsJson()) {
            return response()->json([
                'messages' => MessageResource::collection($messages),
            ]);
        }

        return Inertia::render('home', [
            'messages' => MessageResource::collection($messages),
        ]);
    }
}
