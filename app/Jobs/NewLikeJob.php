<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Models\Message;
use App\Models\User;
use App\Notifications\NewLikeNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

final class NewLikeJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        protected User $user,
        protected User $currentUser,
        public Message $message,
    ) {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->user->notify(
            new NewLikeNotification(
                $this->user,
                $this->currentUser,
                $this->message,
            ),
        );
    }
}
