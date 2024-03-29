<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('channel_for_everyone', function ($user) {
    return true;
});

Broadcast::channel('message.{userId}', function ($userId) {
    dd($userId);

    return Auth::check() && $userId == Auth::id();
});
