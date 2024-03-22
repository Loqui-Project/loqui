<?php

namespace App\Interfaces;

use App\Models\Message;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as SupportCollection;

interface MessageRepositoryInterface
{

    /**
     * Get messages that send to the users you follow and has replay
     *
     * @param int $id
     *
     * @return SupportCollection
     */
    public function getMessages(int $id): SupportCollection;

    /**
     * Get all messages for a user by id
     *
     * @param int $id
     * @param bool $haveReplay
     *
     * @return Collection
     */
    public function getAllMessages(int $id, bool $haveReplay): Collection;


    /**
     * Get message by id
     *
     * @param int $id
     *
     * @return Message|null
     */
    public function getMessageById(int $id): Message|null;

    /**
     * Create a new message
     *
     * @param array $data
     *
     * @return Message
     */
    public function createMessage(array $data): Message;

    public function likeMessage(int $id, int $userId): bool;

    public function favoriteMessage(int $id, int $userId): bool;

}
