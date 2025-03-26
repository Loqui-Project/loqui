<?php

declare(strict_types=1);

namespace App\Http\Controllers\Settings;

use App\Enums\NotificationChannel;
use App\Enums\NotificationType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\UpdateNotificationRequest;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

final class NotificationController extends Controller
{
    /**
     * Show the user's password settings page.
     */
    public function edit(): \Inertia\Response
    {

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

        $userNotificationSettings = Auth::user()->notificationSettings->groupBy('key')->mapWithKeys(function ($settings, $key) {

            return [
                $key => $settings->mapWithKeys(function ($setting) {
                    $setting = $setting->only(['type', 'value']);

                    return [$setting['type']->value => $setting['value']];
                }),
            ];
        });

        return Inertia::render('settings/notifications', [
            'types' => $types,
            'channels' => $channels,
            'userNotificationSettings' => $userNotificationSettings,
        ]);
    }

    /**
     * Update the user's notification settings.
     */
    public function update(UpdateNotificationRequest $request): \Illuminate\Http\RedirectResponse
    {
        $user = Auth::user();

        $user->notificationSettings()->delete();
        $data = $request->validated();

        $settings = collect($data)->map(function ($channel, $key) {
            return collect($channel)->map(function ($value, $type) use ($key) {
                return [
                    'key' => $key,
                    'type' => $type,
                    'value' => $value,
                ];
            });
        })->flatten(1);

        $user->notificationSettings()->createMany($settings);

        return redirect()->back()->with('success', 'Notification settings updated.');
    }
}
