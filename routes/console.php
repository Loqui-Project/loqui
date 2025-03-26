<?php

declare(strict_types=1);

use App\Console\Commands\DeleteNonEmailVerifiedUsersCommand;
use App\Console\Commands\SendUnreadNotificationEmailsCommand;
use Illuminate\Support\Facades\Schedule;

Schedule::command(SendUnreadNotificationEmailsCommand::class)->dailyAt('13:00');
Schedule::command(SendUnreadNotificationEmailsCommand::class, ['--weekly' => true])->weekly()->mondays()->at('13:00');
Schedule::command(DeleteNonEmailVerifiedUsersCommand::class)->hourly();
