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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

final class MessageController extends Controller
{
    /**
     * Display messages that without replies for the user.
     */
    public function inbox(Request $request): \Inertia\Response|\Illuminate\Http\JsonResponse
    {
        $user = type($request->user())->as(User::class);

        $messages = Message::where('user_id', $user->id)->withoutReplies()->paginate(5);
        if ($request->wantsJson()) {
            return response()->json([
                'messages' => MessageResource::collection($messages),
            ]);
        }

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
            'message' => new MessageResource($message),
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
            $user = type($request->user())->as(User::class);
            if ($user->id === $request->receiver_id) {
                return response()->json(['message' => 'You can not send message to yourself'], 400);
            }
            if ($user !== null) {
                $message = Message::create([
                    'sender_id' => $user->id,
                    'user_id' => $request->receiver_id,
                    'message' => $request->message,
                    'is_anon' => false,
                ]);
            } else {
                $message = Message::create([
                    'user_id' => $request->receiver_id,
                    'message' => $request->message,
                    'is_anon' => true,
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
        $messages = Message::whereHas('favorites', function ($query) use ($user): void {
            $query->where('user_id', $user->id);
        })->get();

        return Inertia::render('message/favorites', [
            'messages' => MessageResource::collection($messages),
        ]);
    }
}
