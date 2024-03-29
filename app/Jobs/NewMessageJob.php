<?php

namespace App\Jobs;

use App\Events\NewMessageEvent;
use App\Models\Message;
use App\Models\Notification;
use App\NotificationTypeEnum;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class NewMessageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public Message $message)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        NewMessageEvent::dispatch($this->message);
        Notification::create([
            'user_id' => $this->message->user_id,
            'type' => NotificationTypeEnum::NEW_MESSAGE,
            'data' => [
                'message_id' => $this->message->id,
                'sender_id' => $this->message->sender_id,
            ],
        ]);
    }
}
