<?php

namespace App\Repositories;

use App\Interfaces\MessageRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Models\Message;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection as SupportCollection;

class MessageRepository implements MessageRepositoryInterface
{
    protected UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Get all messages for a user by id
     *
     * @param  int  $id
     */
    public function getAllMessages($id, $haveReplay = false): Collection
    {
        /** @var User $user */
        $user = $this->userRepository->getUserById($id);
        /** @var Collection $userMessages */
        $userMessages = $user->messages()->when($haveReplay == false, function (Builder $query) {
            $query->doesntHave('replay');
        }, function (Builder $query) {
            $query->has('replay');
        })->get();

        return $userMessages;
    }

    /**
     * Get message by id
     */
    public function getMessageById(int $id): ?Message
    {
        return Message::find($id);
    }

    /**
     * Create a new message
     */
    public function createMessage(array $data): Message
    {
        $message = new Message($data);
        $message->save();

        return $message;
    }

    /**
     * Get messages that send to the users you follow and has replay
     *
     *
     * @return Collection
     */
    public function getMessages(int $id): SupportCollection
    {
        /** @var User $user */
        $user = $this->userRepository->getUserById($id);
        $users = $user->following()->get()->pluck('id');
        $messages = Message::whereIn('user_id', $users)->has('replay')->get();

        return $messages;
    }

    /**
     * Like a message
     */
    public function likeMessage(int $id, int $userId): bool
    {
        $message = $this->getMessageById($id);
        if ($message === null) {
            return false;
        }
        /** @var HasMany $likes */
        $likes = $message->likes();
        // check if user already like the message
        $like = $likes->get()->where('user_id', $userId)->first();
        if ($like !== null) {
            // remove the like
            return $like->delete();
        }
        $likes->create([
            'user_id' => $userId,
            'message_id' => $id,
        ]);

        return true;
    }

    /**
     * Favorite a message
     */
    public function favoriteMessage(int $id, int $userId): bool
    {
        $message = $this->getMessageById($id);
        if ($message === null) {
            return false;
        }
        /** @var HasMany $favorites */
        $favorites = $message->favorites();
        // check if user already favorite the message
        $favorite = $favorites->get()->where('user_id', $userId)->first();
        if ($favorite !== null) {
            // remove the favorite
            return $favorite->delete();
        }
        $favorites->create([
            'user_id' => $userId,
            'message_id' => $id,
        ]);

        return true;
    }
}
