<?php

declare(strict_types=1);

use App\Http\Controllers\HomeController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\User\UserProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return Inertia\Inertia::render('welcome');
})->name('welcome');

Route::match(
    ['get', 'post'],
    '/@{user:username}',
    [UserProfileController::class, 'profile']
)->name('profile');

Route::middleware(['auth:api'])->match(['get', 'post'], 'home', HomeController::class)->name('home');
Route::middleware(['auth:api'])->match(['get', 'post'], '/inbox', [MessageController::class, 'inbox'])->name('inbox');
Route::prefix('message')->name('message.')->controller(MessageController::class)->group(function () {
    Route::middleware("auth:api")->group(function (){
        Route::post('/like', 'like')->name('like');
        Route::post('/add-reply', 'addReply')->name('add-reply');
        Route::get('/favorites', 'favorites')->name('favorites');
        Route::post('/add-to-favorite', 'addToFavorite')->name('addToFavorite');
        Route::delete('/', 'delete')->name('delete-message');
    });

    Route::post('/send', 'sendMessage')->name('send');
    Route::get('/{message:id}', 'show')->name('show');
});

Route::middleware(['auth:api'])->controller(NotificationController::class)->name('notifications.')->prefix('notifications')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('/mark-all-read', 'markAllAsRead')->name('markAllAsRead');
    Route::post('/mark-read', 'markAsRead')->name('markAsRead');
});
Route::controller(UserController::class)->prefix('user')->name('user.')->group(function () {
    Route::middleware(['auth:api'])->post('/follow', 'follow')->name('follow');
    Route::middleware(['auth:api'])->post('/unfollow', 'unfollow')->name('unfollow');
    Route::get('/{user:username}/followers', 'followers')->name('followers');
    Route::get('/{user:username}/followings', 'followings')->name('followings');
});

Route::middleware(['auth:api'])->get("/search", SearchController::class)->name('search');
require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
