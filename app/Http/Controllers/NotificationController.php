<?php

namespace App\Http\Controllers;

use App\Enums\NotificationType;
use App\Http\Requests\StoreNotificationRequest;
use App\Http\Requests\UpdateNotificationRequest;
use App\Http\Resources\NotificationResource;
use App\Models\Notification;
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
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreNotificationRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Notification $notification)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Notification $notification)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateNotificationRequest $request, Notification $notification)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Notification $notification)
    {
        //
    }
}
