<?php

declare(strict_types=1);

use App\Livewire\Pages\Auth\SignIn;
use App\Livewire\Pages\Home;
use App\Models\User;
use Livewire\Livewire;

describe('Sign In Tests', function () {
    it('Access Home without sign in', function () {
        Livewire::test(Home::class)->assertRedirect(SignIn::class);
    });
    it('Has auth/signin page', function () {
        $this->get(route('auth.sign-in'))
            ->assertSeeLivewire(SignIn::class);
    });
    it('Email field required', function () {
        Livewire::test(SignIn::class)
            ->set('password', 'password')
            ->call('signIn')->assertHasErrors(['email']);
    });
    it('Password field required', function () {
        Livewire::test(SignIn::class)
            ->set('email', 'testing@testing.com')
            ->call('signIn')->assertHasErrors(['password']);
    });
    it('Can sign in', function () {
        User::factory()->create([
            'email' => 'testing@testing.com',
        ]);
        Livewire::test(SignIn::class)
            ->set('email', 'testing@testing.com')
            ->set('password', 'password')
            ->call('signIn')->assertHasNoErrors(['email', 'password'])->assertRedirect(Home::class);
    });
});
