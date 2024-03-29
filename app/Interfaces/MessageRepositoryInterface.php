<?php

namespace App\Interfaces;

use App\Models\Message;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as SupportCollection;

interface MessageRepositoryInterface
{
    /**
     * Get messages that send to the users you follow and has replay
     */
    public function getMessages(int $id): SupportCollection;

    /**
     * Get all messages for a user by id
     */
    public function getAllMessages(int $id, bool $haveReplay): Collection;

    /**
     * Get message by id
     */
    public function getMessageById(int $id): ?Message;

    /**
     * Create a new message
     */
    public function createMessage(array $data): Message;

    public function likeMessage(int $id, int $userId): bool;

    public function favoriteMessage(int $id, int $userId): bool;
}
