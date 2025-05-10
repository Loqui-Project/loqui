<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\NotificationType;
use App\Http\Resources\NotificationResource;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

final class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): \Inertia\Response
    {
        $user = type($request->user())->as(User::class);
        $filterType = $request->get('type');
        $types = array_map(fn (NotificationType $type): array => [
            'value' => $type->value,
            'label' => $type->getLabel(),
        ], NotificationType::cases());

        $notifications = $user->notifications;
        if ($filterType !== 'all' && $filterType !== null) {
            $notifications = $notifications->where('type', $filterType);
        }

        return Inertia::render('notifications/index', [
            'notifications' => NotificationResource::collection($notifications),
            'types' => $types,
        ]);
    }

    /**
     * Mark all notifications as read.
     */
    public function markAllAsRead(Request $request): \Illuminate\Http\RedirectResponse
    {
        $user = type($request->user())->as(User::class);

        $user->unreadNotifications()->update(['read_at' => now()]);

        return redirect()->back();
    }

    /**
     * Mark a specific notification as read.
     */
    public function markAsRead(Request $request, string $id): \Illuminate\Http\RedirectResponse
    {
        $user = type($request->user())->as(User::class);
        $notification = $user->notifications()->where('id', $id)->first();
        if ($notification !== null) {
            $notification->markAsRead();
        }

        return redirect()->back();
    }
}
