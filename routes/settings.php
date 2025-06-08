<?php

declare(strict_types=1);

use App\Http\Controllers\Settings\NotificationController;
use App\Http\Controllers\Settings\PasswordController;
use App\Http\Controllers\Settings\ProfileController;
use App\Http\Controllers\Settings\SecurityController;
use App\Http\Controllers\Settings\SessionController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->prefix('settings')->name('settings.')->group(function () {

    Route::post("/profile", ProfileController::class)->name('profile');

    Route::post("/password", PasswordController::class)->name("password");

    Route::controller(SecurityController::class)->name('security.')->prefix('security')->group(function () {
        Route::get('/', 'edit')->name('edit');
        Route::delete('/', 'destroy')->name('destroy');
        Route::put('/', 'deactivate')->name('deactivate');
        Route::post('/{provider}/disconnect', 'disconnectProvider')->name('disconnect');
    });

    Route::controller(SessionController::class)->name('sessions.')->prefix('sessions')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::delete('/', 'destroy')->name('destroy');
    });

    Route::controller(NotificationController::class)->name('notifications.')->prefix('notifications')->group(function () {
        Route::get('/', 'edit')->name('edit');
        Route::post('/', 'update')->name('update');
    });
});
