<?php

use App\Livewire\Pages\Auth\SignUp;
use App\Livewire\Pages\Home;
use App\Models\MediaObject;
use App\Models\User;
use Livewire\Livewire;


describe("Sign Up Tests", function () {
    it('Has auth/sign-up page', function () {
        $this->get(route("auth.sign-up"))
            ->assertSeeLivewire(SignUp::class);
    });
    it('"Name" field required', function () {
        Livewire::test(SignUp::class)
            ->set('username', 'testing')
            ->set('email', 'testing@testing.com')
            ->set('password', 'password')
            ->set('password_confirmation', 'password')
            ->call('signUp')->assertHasErrors(['name']);
    });

    it('"Username" field required', function () {
        Livewire::test(SignUp::class)
            ->set('name', 'testing')
            ->set('email', 'testing@testing.com')
            ->set('password', 'password')
            ->set('password_confirmation', 'password')
            ->call('signUp')->assertHasErrors(['username']);
    });
    it('"Username" field must be unique', function () {
        $media = MediaObject::factory()->create();
        User::factory()->create([
            'username' => 'testing',
            'email' => 'testing@testing.com',
            'media_object_id' => $media->id,
        ]);
        Livewire::test(SignUp::class)
            ->set('name', 'testing')
            ->set('username', 'testing')
            ->set('email', 'testing2@testing.com')
            ->set('password', 'password')
            ->set('password_confirmation', 'password')
            ->call('signUp')->assertHasErrors(['username']);
    });
    it('"Email" field required', function () {

        Livewire::test(SignUp::class)
            ->set('name', 'testing')
            ->set('username', 'testing')
            ->set('password', 'password')
            ->set('password_confirmation', 'password')
            ->call('signUp')->assertHasErrors(['email']);
    });
    it('"Email" field must be unique', function () {
        $media = MediaObject::factory()->create();
        User::factory()->create([
            'email' => 'testing@testing.com',
            'media_object_id' => $media->id,
        ]);
        Livewire::test(SignUp::class)
            ->set('name', 'testing')
            ->set('username', 'testing')
            ->set('email', 'testing@testing.com')
            ->set('password', 'password')
            ->set('password_confirmation', 'password')
            ->call('signUp')->assertHasErrors(['email']);
    });
    it('"Password" field required', function () {
        Livewire::test(SignUp::class)
            ->set('name', 'testing')
            ->set('username', 'testing')
            ->set('email', 'testing@testing.com')
            ->set('password_confirmation', 'password')
            ->call('signUp')->assertHasErrors(['password']);
    });
    it('"Password Confirmation" field required', function () {
        Livewire::test(SignUp::class)
            ->set('name', 'testing')
            ->set('username', 'testing')
            ->set('email', 'testing@testing.com')
            ->set('password', 'password')
            ->call('signUp')->assertHasErrors(['password_confirmation']);
    });
    it('"Password Confirmation" must match password field', function () {
        Livewire::test(SignUp::class)
            ->set('name', 'testing')
            ->set('username', 'testing')
            ->set('email', 'testing@testing.com')
            ->set('password', 'password')
            ->set('password_confirmation', 'passteword')
            ->call('signUp')->assertHasErrors(['password']);
    });
    it('Can sign up', function () {
        Livewire::test(SignUp::class)
            ->set('name', 'testing')
            ->set('username', 'testing')
            ->set('email', 'testing@gmail.com')
            ->set('password', 'password')
            ->set('password_confirmation', 'password')
            ->call('signUp')->assertHasErrors(['email']);
    });
});
