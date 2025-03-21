<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum UserStatusEnum: string implements HasColor, HasIcon, HasLabel
{
    case ENABLED = 'enabled';
    case DISABLED = 'disabled';
    case DEACTIVATED = 'deactivated';

    public function getLabel(): string
    {
        return match ($this) {
            self::ENABLED => 'Enabled',
            self::DISABLED => 'Disabled',
            self::DEACTIVATED => 'Deactivated',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::ENABLED => 'success',
            self::DISABLED => 'warning',
            self::DEACTIVATED => 'danger',
        };
    }

    public function getIcon(): string
    {
        return match ($this) {
            self::ENABLED => 'heroicon-m-pencil',
            self::DISABLED => 'heroicon-m-eye',
            self::DEACTIVATED => 'heroicon-s-minus-circle',
        };
    }
}
