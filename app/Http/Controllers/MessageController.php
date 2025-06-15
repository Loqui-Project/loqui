<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\Message\AddReplayRequest;
use App\Http\Requests\Message\AddToFavoriteRequest;
use App\Http\Requests\Message\DeleteMessageRequest;
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
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

final class MessageController extends Controller
{
    /**
     * Display messages that without replies for the user.
     */
    public function inbox(): JsonResponse
    {
        $userId = Auth::id();
        $messages = Cache::remember("{$userId}.inbox.messages", 600, function () use ($userId) {
            $query = Message::query()->where('user_id', $userId)->with(['user', 'likes', 'favorites', 'sender', 'replays.user'])->withCount(['likes', 'replays']);

            return $query->doesntHave('replays')->paginate(5);
        });

        return $this->responseFormatter->responseSuccess('', ['messages' => MessageResource::collection($messages)]);

    }

    /**
     * Display messages that with replies for the user.
     */
    public function show(Message $message): JsonResponse
    {
        return $this->responseFormatter->responseSuccess('', ['message' => new MessageResource($message->loadCount(['likes', 'replays'])->load(['user', 'likes', 'favorites', 'sender', 'replays.user']))]);
    }

    /**
     * Like or unlike a message.
     */
    public function like(LikeMessageRequest $request): JsonResponse
    {
        try {
            /* @var User $user */
            $user = type($request->user())->as(User::class);
            /** @var ?Message $message */
            $message = Message::where('id', $request->message_id)->first();
            if ($message === null) {
                return $this->responseFormatter->responseError('Message not found', 404);
            }
            if ($request->like === false) {
                MessageLike::where('user_id', $user->id)->where('message_id', $message->id)->delete();

                return $this->responseFormatter->responseSuccess('Unliked message successfully', [], 201);
            }
            $like = MessageLike::where('user_id', $user->id)->where('message_id', $message->id)->first();
            if ($like !== null) {
                return $this->responseFormatter->responseError('Already liked', 400);
            }
            MessageLike::create(['user_id' => $user->id, 'message_id' => $message->id]);

            return $this->responseFormatter->responseSuccess('Liked message successfully', [], 201);
        } catch (Exception) {
            return $this->responseFormatter->responseError('Error liking message', 500);
        }
    }

    public function delete(DeleteMessageRequest $request): JsonResponse
    {
        try {
            $user = type($request->user())->as(User::class);
            $message = type(Message::findOrFail($request->message_id))->as(Message::class);

            $message->delete();
            Cache::forget('inbox.messages');
            Cache::forget('home.messages');

            return $this->responseFormatter->responseSuccess('Message deleted', [], 201);
        } catch (Exception $e) {
            return $this->responseFormatter->responseError('Error deleting message', 500);
        }
    }

    /**
     * Add a reply to a message.
     */
    public function addReplay(AddReplayRequest $request): JsonResponse
    {
        try {
            $user = type($request->user())->as(User::class);
            $message = type(Message::findOrFail($request->message_id))->as(Message::class);

            $message->replays()->create(['user_id' => $user->id, 'text' => $request->replay]);
            Cache::forget("{$user->id}.inbox.messages");
            Cache::forget("{$user->id}.home.messages");

            return $this->responseFormatter->responseSuccess('Replay added', [], 201);
        } catch (Exception $e) {
            return $this->responseFormatter->responseError('Error adding reply', 500);
        }
    }

    /**
     * Send a message to a user.
     */
    public function sendMessage(SendMessageRequest $request): JsonResponse
    {
        try {
            /** @var User|null $user */
            $user = null;
            $image = $request->file('image');
            $inputs = $request->validated();
            if ($image) {
                $inputs['image_url'] = type($image)->as(UploadedFile::class)->store('images', 'public');
                unset($inputs['image']);
            }
            if ($request->user() === null) {
                $message = Message::create(['user_id' => $request->receiver_id, 'message' => $request->message, 'is_anon' => true, 'image_url' => $inputs['image_url'] ?? null]);
            } else {
                $user = $request->user();
                $message = Message::create(['sender_id' => $user->id, 'user_id' => $request->receiver_id, 'message' => $request->message, 'is_anon' => false, 'image_url' => $inputs['image_url'] ?? null]);
            }

            $recviedUser = User::findOrFail($request->receiver_id);
            NewMessageJob::dispatch(type($recviedUser)->as(User::class), $user, $message);

            return $this->responseFormatter->responseSuccess('Message sent successfully', [], 201);
        } catch (Exception $e) {
            return $this->responseFormatter->responseError('Error sending message', 500);
        }
    }

    /**
     * Add a message to favorite.
     */
    public function addToFavorite(AddToFavoriteRequest $request): JsonResponse
    {
        MessageFavourite::create(['user_id' => Auth::id(), 'message_id' => $request->message_id]);

        return $this->responseFormatter->responseSuccess('Message saved successfully');
    }

    /**
     * Display messages that user liked.
     */
    public function favorites(Request $request): JsonResponse
    {
        $user = type($request->user())->as(User::class);
        $messages = Message::whereHas('favorites', function (Builder $query) use ($user): void {
            $query->where('user_id', $user->id);
        })->get();

        return $this->responseFormatter->responseSuccess('', ['messages' => MessageResource::collection($messages)]);
    }
}
