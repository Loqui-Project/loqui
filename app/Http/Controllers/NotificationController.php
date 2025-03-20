<?php

namespace App\Http\Controllers;

use App\Enums\NotificationType;
use App\Http\Resources\NotificationResource;
use Illuminate\Http\Request;
use Inertia\Inertia;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $filterType = $request->get('type');
        $types = array_map(function ($type) {
            return [
                'value' => $type,
                'label' => $type->getLabel(),
            ];
        }, NotificationType::values());
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
    public function markAllAsRead(Request $request)
    {
        $request->user()->unreadNotifications->markAsRead();

        return redirect()->back();
    }

    /**
     * Mark a specific notification as read.
     */
    public function markAsRead(Request $request, $id)
    {
        $request->user()->notifications()->where('id', $id)->first()->markAsRead();

        return redirect()->back();
    }
}
