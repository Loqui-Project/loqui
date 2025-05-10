<?php

namespace App\Filament\Resources\NotificationResource\Pages;

use App\Filament\Resources\NotificationResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateNotification extends CreateRecord
{
    protected static string $resource = NotificationResource::class;

    /**
     * @param  array<string, mixed>  $data
     */
    protected function handleRecordCreation(array $data): Model
    {

        $notificationType = "SYSTEM";

        $data = array_merge($data, [
            'type' => $notificationType,
            'notifiable_type' => 'App\Models\User',
            'notifiable_id' => $data['notifiable_id'],
            'data' => json_encode([$data['data']]),
        ]);
        $record = $this->getModel()::create($data);
        $record->save();
        return $record;
    }
}
