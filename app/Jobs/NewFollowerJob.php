<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Models\User;
use App\Notifications\NewFollowerNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

final class NewFollowerJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        protected User $user,
        protected User $currentUser,
    ) {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->user->notify(
            new NewFollowerNotification($this->user, $this->currentUser),
        );
    }
}
