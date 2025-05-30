<?php

declare(strict_types=1);

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::controller(UserController::class)->prefix('user')->name('user.')->group(function () {
    Route::middleware(['auth:sanctum'])->post('/follow', 'follow')->name('follow');
    Route::middleware(['auth:sanctum'])->post('/unfollow', 'unfollow')->name('unfollow');
    Route::get('/{user:username}/followers', 'followers')->name('followers');
    Route::get('/{user:username}/followings', 'followings')->name('followings');
    Route::get('/{user:username}/messages', 'messages')->name('messages');
});
