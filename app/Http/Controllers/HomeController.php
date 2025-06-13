<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\MessageResource;
use App\Models\Message;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

final class HomeController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {

        /* @var User $user */
        $user = $request->user();

        if ($user === null) {
            return $this->responseFormatter->responseError('User not found.', 404);
        }
        $followingUsersId = $user->following()->pluck('user_id')->toArray();
        $messages = Cache::remember("home.{$user->id}.messages", 600, function () use ($user, $followingUsersId) {
            /* @var Builder<Message> $query */
            $query = Message::query()->whereIn('user_id', [...$followingUsersId, $user->id])->whereHas(
                'replays',
            )->with(['user', 'likes', 'favorites', 'sender', 'replays.user'])->withCount(['likes', 'replays']);
            return $query->orderByDesc('likes_count')->paginate(5);
        });

        return $this->responseFormatter->responseSuccess('', ['messages' => MessageResource::collection($messages)]);
    }
}
