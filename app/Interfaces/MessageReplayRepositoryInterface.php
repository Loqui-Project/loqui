<?php


namespace App\Interfaces;

interface MessageReplayRepositoryInterface
{
    public function addReplayToMessage(int $messageId, mixed $data): bool;
}
