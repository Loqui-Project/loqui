<?php

namespace App\Repositories;

use App\Interfaces\MessageReplayRepositoryInterface;
use App\Interfaces\MessageRepositoryInterface;
use App\Notifications\NewReplayNotification;
use Illuminate\Support\Facades\Mail;

class MessageReplayRepository implements MessageReplayRepositoryInterface
{

    protected MessageRepositoryInterface $messageRepository;

    public function __construct(MessageRepositoryInterface $messageRepository)
    {
        $this->messageRepository = $messageRepository;
    }


    public function addReplayToMessage(int $messageId, mixed $data): bool
    {
        $message = $this->messageRepository->getMessageById($messageId);
        if ($message === null) {
            return false;
        }
        $replay = $message->replay()->create($data);
        $message->sender->notify(new NewReplayNotification($message, $replay));
        return true;
    }
}
