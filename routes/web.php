<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return Inertia\Inertia::render('welcome');
})->name('welcome');

Route::get(
    '/@{user:username}', [UserController::class, 'profile'])->name('profile');

Route::middleware(['auth'])->get('home', HomeController::class)->name('home');
Route::middleware(['auth'])->get('/inbox', [MessageController::class, 'inbox'])->name('inbox');
Route::prefix('message')->name('message.')->controller(MessageController::class)->group(function () {
    Route::middleware(['auth'])->post('/like', 'like')->name('like');
    Route::middleware(['auth'])->post('/add-reply', 'addReply')->name('add-reply');
    Route::middleware(['auth'])->get('/favorites', 'favorites')->name('favorites');
    Route::middleware(['auth'])->post('/add-to-favorite', 'addToFavorite')->name('addToFavorite');

    Route::post('/send', 'sendMessage')->name('send');
    Route::get('/{message:id}', 'show')->name('show');

});

Route::middleware(['auth'])->controller(NotificationController::class)->name('notifications.')->prefix('notifications')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('/mark-all-as-read', 'markAllAsRead')->name('markAllAsRead');
    Route::post('/mark-as-read/{id}', 'markAsRead')->name('markAsRead');

});
Route::controller(UserController::class)->prefix('user')->name('user.')->group(function () {
    Route::middleware(['auth'])->post('/follow', 'follow')->name('follow');
    Route::middleware(['auth'])->post('/unfollow', 'unfollow')->name('unfollow');
    Route::get('/{user:username}/followers', 'followers')->name('followers');
    Route::get('/{user:username}/followings', 'followings')->name('followings');

});

Route::middleware(['auth'])->controller(SearchController::class)->name('search.')->prefix('search')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/data', 'search')->name('data');

});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
