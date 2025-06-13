<?php

declare(strict_types=1);

use App\Http\Controllers\HomeController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\User\UserProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware("auth:sanctum")->get('/user', function () {
    return response()->json(['isLoggedIn' => true,]);
})->name('user');

Route::middleware("auth:sanctum")->get('/user/{user:username}', [UserProfileController::class, 'profile'])->name('profile');

Route::middleware(['auth:sanctum'])->get('/home', HomeController::class)->name('home');
Route::middleware(['auth:sanctum'])->match(['get', 'post'], '/inbox', [MessageController::class, 'inbox'])->name('inbox');
Route::prefix('message')->name('message.')->controller(MessageController::class)->group(function () {
    Route::middleware("auth:sanctum")->group(function () {
        Route::post('/like', 'like')->name('like');
        Route::post('/replay', 'addReplay')->name('add-reply');
        Route::get('/favorites', 'favorites')->name('favorites');
        Route::post('/add-to-favorite', 'addToFavorite')->name('addToFavorite');
        Route::delete('/', 'delete')->name('delete-message');
    });

    Route::post('/send', 'sendMessage')->name('send');
    Route::get('/{message:id}', 'show')->name('show');
});

Route::middleware(['auth:sanctum'])->controller(NotificationController::class)->name('notifications.')->prefix('notifications')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('/mark-all-read', 'markAllAsRead')->name('markAllAsRead');
    Route::post('/mark-read', 'markAsRead')->name('markAsRead');
});


Route::middleware(['auth:sanctum'])->get("/search", SearchController::class)->name('search');


Route::middleware(['auth:sanctum'])->get('/ping', function () {
    return response()->json(['message' => 'pong']);
})->name('ping');


require __DIR__ . '/auth.php';
require __DIR__ . '/settings.php';
require __DIR__ . '/user.php';
