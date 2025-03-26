<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Mail\PendingNotifications;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

final class SendUnreadNotificationEmailsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:unread-notification-emails
                            {--weekly : Send the unread notification emails to the users who have set their mail preference to weekly.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send the unread notification emails to the users.';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        User::query()
            ->whereHas('notifications')
            ->withCount('notifications')
            ->each(fn (User $user) => Mail::to($user)->queue(new PendingNotifications($user, $user->notifications_count)));
    }
}
