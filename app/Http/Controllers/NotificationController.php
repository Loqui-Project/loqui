<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\NotificationType;
use App\Http\Resources\NotificationResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

final class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        /* @var User $user */
        $user = $request->user();

        if ($user === null) {
            return $this->responseFormatter->responseError('User not found.', 404);
        }
        $filterType = $request->get('type');
        $types = array_map(fn(NotificationType $type): array => [
            'value' => $type->value,
            'label' => $type->getLabel(),
        ], NotificationType::cases());

        $notifications = $user->notifications;
        if ($filterType !== 'all' && $filterType !== null) {
            $notifications = $notifications->where('type', $filterType);
        }
        return $this->responseFormatter->responseSuccess('', [
            'notifications' => NotificationResource::collection($notifications),
            'types' => $types,
        ]);
    }

    /**
     * Mark all notifications as read.
     */
    public function markAllAsRead(Request $request): JsonResponse
    {
        try {
            $user = type($request->user())->as(User::class);

            $user->unreadNotifications()->update(['read_at' => now()]);

            return $this->responseFormatter->responseSuccess(
                'All notifications marked as read',
                [
                ]
            );
        } catch (\Exception $e) {
            return $this->responseFormatter->responseError(
                'Error marking notifications as read',
                500
            );
        }
    }

    /**
     * Mark a specific notification as read.
     */
    public function markAsRead(Request $request): JsonResponse
    {
        try {
            $user = type($request->user())->as(User::class);
            $notification = $user->notifications()->where('id', $request->notification_id)->first();
            if ($notification !== null) {
                $notification->markAsRead();
            }

            return $this->responseFormatter->responseSuccess(
                'Notification marked as read',
                [
                ]
            );
        } catch (\Exception $e) {
            return $this->responseFormatter->responseError(
                'Error marking notification as read',
                500
            );
        }
    }
}
