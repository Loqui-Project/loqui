<?php

declare(strict_types=1);

use App\Console\Commands\DeleteNonEmailVerifiedUsersCommand;
use App\Console\Commands\SendUnreadNotificationEmailsCommand;
use Illuminate\Support\Facades\Schedule;

Schedule::command(SendUnreadNotificationEmailsCommand::class)->dailyAt('13:00');
Schedule::command(DeleteNonEmailVerifiedUsersCommand::class)->hourly();
Schedule::command(Spatie\Health\Commands\RunHealthChecksCommand::class)->everySixHours();
