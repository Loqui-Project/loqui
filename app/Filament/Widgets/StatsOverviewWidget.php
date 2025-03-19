<?php

namespace App\Filament\Widgets;

use App\Enums\UserStatusEnum;
use App\Models\Message;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverviewWidget extends BaseWidget
{
    protected function getColumns(): int
    {
        return 2;
    }

    protected function getStats(): array
    {

        $users = User::count();
        $activeUsers = User::where('status', UserStatusEnum::ENABLED->value)->count();
        $messages = Message::count();

        return [
            Stat::make('Users', $users)
                ->description("{$activeUsers} active users")
                ->color('success'),
            Stat::make('Messages', $messages)
                ->color('success'),
        ];
    }
}
