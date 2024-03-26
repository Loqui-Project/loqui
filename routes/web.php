<?php

use App\Livewire\Pages\Home;
use App\Livewire\Pages\Auth\SignIn;
use App\Livewire\Pages\Auth\SignUp;
use App\Livewire\Pages\Inbox;
use App\Livewire\Pages\Profile\Account;
use App\Livewire\Pages\Profile;
use App\Livewire\Pages\Search;
use Illuminate\Support\Facades\Route;


Route::prefix("/auth")->name("auth.")->group(function () {
    Route::middleware("guest")->group(function () {
        Route::get("/sign-in", SignIn::class)->name("sign-in");
        Route::get("/sign-up", SignUp::class)->name("sign-up");
    });
    Route::middleware("auth")->group(function () {
        Route::get("/sign-out", function () {
            auth()->logout();
            return redirect()->route("auth.sign-in");
        })->name("sign-out");
    });
});


Route::middleware("auth")->group(function () {
    Route::redirect('/', '/home');
    Route::get('/home', Home::class)->name('home');
    Route::get('/inbox', Inbox::class)->name('inbox');
    Route::get('/search', Search::class)->name("search");
    Route::prefix("/profile")->name("profile.")->group(function () {
        Route::get("/account", Account::class)->name("account");
    });
});

Route::get('/@{username}', Profile\UserProfile::class)->name("profile.user");
