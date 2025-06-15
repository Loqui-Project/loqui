<?php

declare(strict_types=1);

namespace App\Http\Controllers\Settings;

use App\Enums\NotificationChannel;
use App\Enums\NotificationType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\UpdateNotificationRequest;
use App\Models\NotificationSetting;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

final class NotificationController extends Controller
{
    /**
     * Show the user's password settings page.
     */
    public function edit(): JsonResponse
    {

        $authUser = type(Auth::user())->as(User::class);
        $authUser->load('notificationSettings');

        $types = array_map(fn (NotificationType $type): array => [
            'value' => $type->value,
            'label' => $type->getLabel(),
            'description' => $type->getDescription(),
        ], NotificationType::cases());

        $channels = array_map(fn (NotificationChannel $type): array => [
            'value' => $type->value,
            'label' => $type->getLabel(),
            'description' => $type->getDescription(),
        ], NotificationChannel::cases());

        $notificationSettings = collect($authUser->notificationSettings)->groupBy('key');

        $userNotificationSettings = $notificationSettings->mapWithKeys(fn (Collection $settings, string $key) => [
            /** @var Collection<string, NotificationSettings> $settings */
            $key => $settings->mapWithKeys(fn (NotificationSetting $setting) => [
                /** @var NotificationSetting $setting */
                $setting->type->value => $setting->value,
            ]),
        ]);

        return $this->responseFormatter->responseSuccess('Notification settings retrieved successfully.', [
            'types' => $types,
            'channels' => $channels,
            'userNotificationSettings' => $userNotificationSettings,
        ]);

    }

    /**
     * Update the user's notification settings.
     */
    public function update(UpdateNotificationRequest $request): JsonResponse
    {
        /** @var User */
        $user = Auth::user();

        $user->notificationSettings()->delete();
        /** @var Collection<string, array<string, bool>> */
        $data = collect($request->validated());

        $settings = $data->map(fn (array $channel, string $key) => collect($channel)->map(fn (bool $value, string $type): array => [
            'key' => $key,
            'type' => $type,
            'value' => $value,
        ]))->flatten(1)->toArray();

        foreach ($settings as $setting) {
            /** @var array<string, string|bool> $setting */
            NotificationSetting::create([
                'user_id' => $user->id,
                'key' => $setting['key'],
                'type' => $setting['type'],
                'value' => $setting['value'],
            ]);
        }

        return $this->responseFormatter->responseSuccess(
            'Notification settings updated successfully.',
            [

            ],
        );
    }
}
