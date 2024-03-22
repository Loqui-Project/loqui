<?php

use App\Livewire\Pages\Home;
use App\Livewire\Pages\Auth\SignIn;
use App\Livewire\Pages\Auth\SignUp;
use Illuminate\Support\Facades\Route;

Route::get('/', Home::class)->name('home');

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
