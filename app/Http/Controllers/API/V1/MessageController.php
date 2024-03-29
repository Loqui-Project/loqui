<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\Handler;
use App\Http\Requests\API\Message\AddReplayToMessageRequest;
use App\Http\Requests\API\Message\FavoriteMessageRequest;
use App\Http\Requests\API\Message\LikeMessageRequest;
use App\Http\Requests\API\Message\SendMessageRequest;
use App\Http\Resources\MessageResource;
use App\Interfaces\MessageReplayRepositoryInterface;
use App\Interfaces\MessageRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class MessageController extends Handler
{
    public function __construct(protected MessageRepositoryInterface $messageRepository, protected MessageReplayRepositoryInterface $messageReplayRepository)
    {
    }

    // get messages that send to the users you follow and has replay
    public function getMessages(Request $request)
    {
        $currentUser = $request->user();
        $messages = Cache::store('redis')->remember('user:'.$currentUser->id.':messages:follow', 60 * 60 * 1, function () use ($currentUser) {
            return $this->messageRepository->getMessages($currentUser->id);
        });

        return $this->responseSuccess(MessageResource::collection($messages->load('replay')));
    }

    /**
     * Get all messages for a user by id and has replay
     *
     * @param  int  $id
     */
    public function getAllMessagesWithReplay(Request $request): JsonResponse
    {
        /* @var \App\Models\User $currentUser */
        $currentUser = $request->user('auth:api');
        $messages = Cache::store('redis')->remember('user:'.$currentUser->id.':messages:with_replay', 60 * 60 * 1, function () use ($currentUser) {
            return $this->messageRepository->getAllMessages($currentUser->id, true);
        });

        return $this->responseSuccess(MessageResource::collection($messages->load('replay')));
    }

    /**
     * Get all messages for a user by id and has no replay
     */
    public function getAllMessagesWithoutReplay(Request $request): JsonResponse
    {
        $currentUser = $request->user();
        $messages = Cache::store('redis')->remember('user:'.$currentUser->id.':messages:without_replay', 60 * 60 * 1, function () use ($currentUser) {
            return $this->messageRepository->getAllMessages($currentUser->id, false);
        });

        return $this->responseSuccess(MessageResource::collection($messages));
    }

    public function getMessageById(Request $request, int $id): JsonResponse
    {
        $currentUser = $request->user();
        $message = Cache::store('redis')->remember('user:'.$currentUser->id.':message:'.$id, 60 * 60 * 1, function () use ($id) {
            $message = $this->messageRepository->getMessageById($id);

            return $message;
        });
        if ($message === null) {
            return $this->responseError('Message not found', 404);
        }

        return $this->responseSuccess(new MessageResource($message));
    }

    /**
     * Create a new message
     *
     *
     * @return JsonResponse
     */
    public function sendMessage(SendMessageRequest $request)
    {
        try {
            $currentUser = $request->user();
            if ($currentUser->id != $request->sender_id) {
                return $this->responseError('Sender id must be matching with the current user authenticated', 400);
            }
            /* @var \App\Models\Message $message */
            $message = $this->messageRepository->createMessage($request->validated());
            Cache::store('redis')->forget('user:'.$currentUser->id.':messages:with_replay');
            Cache::store('redis')->forget('user:'.$currentUser->id.':messages:without_replay');

            return $this->responseSuccess($message, 201);
        } catch (\Throwable $th) {
            return $this->responseError($th->getMessage(), 500);
        }
    }

    public function replayMessage(AddReplayToMessageRequest $request)
    {
        try {
            $currentUser = $request->user();
            $message = $this->messageReplayRepository->addReplayToMessage($request->getMessageId(), $request->getData());
            Cache::store('redis')->forget('user:'.$currentUser->id.':messages:with_replay');
            Cache::store('redis')->forget('user:'.$currentUser->id.':messages:without_replay');

            return $this->responseSuccess($message);
        } catch (\Throwable $th) {
            return $this->responseError($th->getMessage(), 500);
        }
    }

    public function likeMessage(LikeMessageRequest $request)
    {
        try {
            $currentUser = $request->user();
            $message = $this->messageRepository->likeMessage($request->getMessageId(), $currentUser->id);
            Cache::store('redis')->forget('user:'.$currentUser->id.':messages:with_replay');
            Cache::store('redis')->forget('user:'.$currentUser->id.':messages:without_replay');

            return $this->responseSuccess($message);
        } catch (\Throwable $th) {
            return $this->responseError($th->getMessage(), 500);
        }
    }

    public function favoriteMessage(FavoriteMessageRequest $request)
    {
        try {
            $currentUser = $request->user();
            $message = $this->messageRepository->favoriteMessage($request->getMessageId(), $currentUser->id);
            Cache::store('redis')->forget('user:'.$currentUser->id.':messages:with_replay');
            Cache::store('redis')->forget('user:'.$currentUser->id.':messages:without_replay');

            return $this->responseSuccess($message);
        } catch (\Throwable $th) {
            return $this->responseError($th->getMessage(), 500);
        }
    }
}
