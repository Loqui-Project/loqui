<?php

declare(strict_types=1);

use App\Livewire\Pages\Auth\SignIn;
use App\Livewire\Pages\Auth\SignUp;
use App\Livewire\Pages\Changelog;
use App\Livewire\Pages\Home;
use App\Livewire\Pages\Inbox;
use App\Livewire\Pages\MessageShow;
use App\Livewire\Pages\NotificationPage;
use App\Livewire\Pages\Password\Forget;
use App\Livewire\Pages\Password\Reset;
use App\Livewire\Pages\Profile;
use App\Livewire\Pages\Search;
use Illuminate\Support\Facades\Route;

Route::prefix('/auth')
    ->name('auth.')
    ->group(function () {
        Route::middleware('guest')->group(function () {
            Route::get('/sign-in', SignIn::class)->name('sign-in');
            Route::get('/sign-up', SignUp::class)->name('sign-up');
        });
        Route::middleware('auth')->group(function () {
            Route::get('/sign-out', function () {
                Auth::logout();

                return redirect()->route('auth.sign-in');
            })->name('sign-out');
        });
    });
Route::prefix('/@{user}')->group(function () {
    Route::get('', Profile\UserProfile::class)->name(
        'profile.user',
    );
    Route::middleware('auth')->get('/following', Profile\FollowingUsers::class)->name('profile.following');
});
Route::middleware('auth')->group(function () {
    Route::redirect('/', '/home');
    Route::get('/home', Home::class)->name('home');
    Route::get('/inbox', Inbox::class)->name('inbox');
    Route::get('/search', Search::class)->name('search');
    Route::prefix('/profile')
        ->name('profile.')
        ->group(function () {
            Route::prefix('/settings')->name('settings.')->group(function () {
                Route::get('/account', Profile\Settings\Account::class)->name('account');
                Route::get('/sessions', Profile\Settings\Sessions::class)->name('sessions');
                Route::get('/security', Profile\Settings\Security::class)->name('security');
                Route::get('/notifications', Profile\Settings\Notification::class)->name('notifications');
                Route::get('/appearance', Profile\Settings\Appearance::class)->name('appearance');
            });
            Route::get('/favorites', Profile\Favorite::class)->name(
                'favorites',
            );
        });
    Route::get('/notifications', NotificationPage::class)->name(
        'notifications',
    );
});
Route::get('/message/{id}', MessageShow::class)->name('message.show');
Route::name('password.')
    ->prefix('password')
    ->group(function () {
        Route::get('forget', Forget::class)->name('forget');
        Route::get('reset', Reset::class)->name('reset');
    });

Route::get('/changelog', Changelog::class)->name('changelog');
