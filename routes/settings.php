<?php

declare(strict_types=1);

use App\Http\Controllers\Settings\PasswordController;
use App\Http\Controllers\Settings\ProfileController;
use App\Http\Controllers\Settings\SecurityController;
use App\Http\Controllers\Settings\SessionController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->prefix('settings')->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::controller(ProfileController::class)->name('profile.')->prefix('profile')->group(function () {
        Route::get('/', 'edit')->name('edit');
        Route::put('/', 'update')->name('update');
    });

    Route::controller(PasswordController::class)->name('password.')->prefix('password')->group(function () {

        Route::get('/', 'edit')->name('edit');
        Route::put('/', 'update')->name('update');
    });

    Route::controller(SecurityController::class)->name('security.')->prefix('security')->group(function () {
        Route::get('/', 'edit')->name('edit');
        Route::delete('/', 'destroy')->name('destroy');
        Route::put('/', 'deactivate')->name('deactivate');
    });

    Route::controller(SessionController::class)->name('sessions.')->prefix('session')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::delete('/{session}', 'destroy')->name('destroy');
    });
});
