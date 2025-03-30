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
    public function __invoke(Request $request): \Inertia\Response
    {
        $user = type($request->user())->as(User::class);
        $followingUsersId = $user->following()->pluck('user_id')->toArray();
        $messages = Message::whereIn('user_id', [
            ...$followingUsersId,
            $user->id,
        ])->with(['user', 'likes', 'favorites', 'sender', 'replays.user'])->withCount([
            'likes',
            'replays',
        ])->withReplies()->orderBy(
            'likes_count',
            'desc'
        )->paginate(5);

        return Inertia::render('home', [
            'messages' => Inertia::merge(fn () => MessageResource::collection($messages)),
        ]);
    }
}
