<?php

namespace App\Jobs;

use App\Events\NewFollowerEvent;
use App\Models\Notification;
use App\Models\User;
use App\NotificationTypeEnum;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class NewFollowerJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(protected readonly User $user, protected readonly User $followerUser)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        NewFollowerEvent::dispatch($this->user, $this->followerUser);
        Notification::create([
            'user_id' => $this->user->id,
            'type' => NotificationTypeEnum::NEW_FOLLOWER,
            'data' => [
                'follower_id' => $this->followerUser->id,
            ],
        ]);
    }
}
