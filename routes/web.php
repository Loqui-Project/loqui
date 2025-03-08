<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;



Route::get(
    "/@{user:username}", [UserController::class, 'profile'])->name('profile');

Route::middleware(['auth'])->group(function () {
    Route::get('home', HomeController::class)->name('home');
    Route::prefix('message')->name('message.')->group(function () {
        Route::post('/like', [MessageController::class, 'like'])->name('like');
        Route::post('/add-reply', [MessageController::class, 'addReply'])->name('add-reply');
        Route::post('/send', [MessageController::class, 'sendMessage'])->name('send');
        Route::get("/{message:id}", [MessageController::class, 'show'])->name('show');
    });
    Route::get('/notifications', [\App\Http\Controllers\NotificationController::class, 'index'])->name('notifications');
});


require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
