<?php

declare(strict_types=1);

namespace App\Filament\Resources\MessageResource\Pages;

use App\Filament\Resources\MessageResource;
use Filament\Resources\Pages\ListRecords;

final class ListMessages extends ListRecords
{
    protected static string $resource = MessageResource::class;
}
