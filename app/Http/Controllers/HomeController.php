<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\MessageResource;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Inertia\Inertia;

final class HomeController extends Controller
{
    public function __invoke(Request $request): \Inertia\Response
    {
        $user = type($request->user())->as(User::class);
        $followingUsersId = $user->following()->pluck('user_id')->toArray();
        $messages = Cache::remember('home.messages', 600, function () use ($user, $followingUsersId) {
            return Message::whereIn('user_id', [
                ...$followingUsersId,
                $user->id,
            ])->with(['user', 'likes', 'favorites', 'sender', 'replays.user'])->withCount([
                'likes',
                'replays',
            ])->withReplies()->orderBy(
                'likes_count',
                'desc'
            )->paginate(5);
        }, 300);

        return Inertia::render('home', [
            'messages' => Inertia::merge(fn () => MessageResource::collection($messages)),
        ]);
    }
}
