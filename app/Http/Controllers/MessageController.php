<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\Message\AddReplayRequest;
use App\Http\Requests\Message\AddToFavoriteRequest;
use App\Http\Requests\Message\LikeMessageRequest;
use App\Http\Requests\Message\SendMessageRequest;
use App\Http\Resources\MessageResource;
use App\Jobs\NewMessageJob;
use App\Models\Message;
use App\Models\MessageFavourite;
use App\Models\MessageLike;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Inertia\Inertia;

final class MessageController extends Controller
{
    /**
     * Display messages that without replies for the user.
     */
    public function inbox(): \Inertia\Response
    {
        $messages = Cache::remember('inbox.messages', 600, function () {
            return Message::where('user_id', Auth::id())->with(['user', 'likes', 'favorites', 'sender', 'replays.user'])->withCount([
                'likes',
                'replays',
            ])->withoutReplies()->paginate(5);
        }, 300);

        return Inertia::render('message/inbox', [
            'messages' => MessageResource::collection($messages),
        ]);

    }

    /**
     * Display messages that with replies for the user.
     */
    public function show(Message $message): \Inertia\Response
    {
        return Inertia::render('message/show', [
            'message' => new MessageResource($message->loadCount([
                'likes',
                'replays',
            ])->load(['user', 'likes', 'favorites', 'sender', 'replays.user'])),
        ]);
    }

    /**
     * Like or unlike a message.
     */
    public function like(LikeMessageRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            $user = type($request->user())->as(User::class);

            /** @var ?Message $message */
            $message = Message::where('id', $request->message_id)->first();
            if ($message === null) {
                return response()->json(['message' => 'Message not found'], 404);
            }
            if ($request->like === false) {
                MessageLike::where('user_id', $user->id)->where('message_id', $message->id)->delete();

                return response()->json(['message' => 'Unliked message successfully']);
            }
            $like = MessageLike::where('user_id', $user->id)->where('message_id', $message->id)->first();
            if ($like !== null) {
                return response()->json(['message' => 'You already liked this message'], 400);
            }
            MessageLike::create([
                'user_id' => $user->id,
                'message_id' => $message->id,
            ]);

            return response()->json(['message' => 'Liked message successfully']);
        } catch (Exception) {
            return response()->json(['message' => 'Failed to like'], 500);
        }
    }

    /**
     * Add a reply to a message.
     */
    public function addReply(AddReplayRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            $user = type($request->user())->as(User::class);
            $message = type(Message::findOrFail($request->message_id))->as(Message::class);

            $message->replays()->create([
                'user_id' => $user->id,
                'text' => $request->replay,
            ]);
            Cache::forget('inbox.messages');
            Cache::forget('home.messages');

            return response()->json(['message' => 'Reply added']);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Send a message to a user.
     */
    public function sendMessage(SendMessageRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            /** @var User|null $user */
            $user = null;
            $image = $request->file('image');
            if ($image) {
                $inputs['image_url'] = type($image)->as(UploadedFile::class)->store('images', 'public');
                unset($inputs['image']);
            }
            if ($request->user() === null) {
                $image = $request->file('image');

                $message = Message::create([
                    'user_id' => $request->receiver_id,
                    'message' => $request->message,
                    'is_anon' => true,
                    'image_url' => $inputs['image_url'] ?? null,
                ]);
            } else {
                $image = $request->file('image');
                $user = $request->user();
                $message = Message::create([
                    'sender_id' => $user->id,
                    'user_id' => $request->receiver_id,
                    'message' => $request->message,
                    'is_anon' => false,
                    'image_url' => $inputs['image_url'] ?? null,
                ]);
            }

            $recviedUser = User::findOrFail($request->receiver_id);
            NewMessageJob::dispatch(type($recviedUser)->as(User::class), $user, $message);

            return response()->json(['message' => 'Message sent successfully']);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Add a message to favorite.
     */
    public function addToFavorite(AddToFavoriteRequest $request): \Illuminate\Http\JsonResponse
    {
        MessageFavourite::create([
            'user_id' => Auth::id(),
            'message_id' => $request->message_id,
        ]);

        return response()->json(['message' => 'Message saved successfully']);
    }

    /**
     * Display messages that user liked.
     */
    public function favorites(Request $request): \Inertia\Response
    {
        $user = type($request->user())->as(User::class);
        $messages = Message::whereHas('favorites', function (Builder $query) use ($user): void {
            $query->where('user_id', $user->id);
        })->get();

        return Inertia::render('message/favorites', [
            'messages' => MessageResource::collection($messages),
        ]);
    }
}
