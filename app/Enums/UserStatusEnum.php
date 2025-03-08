<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum UserStatusEnum: string implements HasColor, HasIcon, HasLabel
{
    case ENABLED = 'enabled';
    case DISABLED = 'disabled';

    public static function toArray(): array
    {
        return [
            self::ENABLED => 'Enabled',
            self::DISABLED => 'Disabled',
        ];
    }

    public function getLabel(): ?string
    {
        return match ($this) {
            self::ENABLED => 'Enabled',
            self::DISABLED => 'Disabled',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::ENABLED => 'success',
            self::DISABLED => 'warning',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::ENABLED => 'heroicon-m-pencil',
            self::DISABLED => 'heroicon-m-eye',
        };
    }
}
