<?php

use App\Models\User;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

describe('Authentication', function () {
    describe('Validation', function () {
        test('Throw error when email is not provided', function () {
            $response = $this->post('/login', [
                'password' => 'password',
            ]);

            $response->assertSessionHasErrors('email');
        });
        test('Throw error when password is not provided', function () {
            $response = $this->post('/login', [
                'email' => fake()->email,
            ]);

            $response->assertSessionHasErrors('password');
        });
        test('Throw error when email is not valid', function () {
            $response = $this->post('/login', [
                'email' => 'invalid-email',
                'password' => 'password',
            ]);

            $response->assertSessionHasErrors('email');
        });

        test('Throw error when user is not found', function () {
            $response = $this->post('/login', [
                'email' => fake()->email,
                'password' => 'password',
            ]);

            $response->assertSessionHasErrors('email');
        });
    })->group('Validation');
    describe('Success', function () {

        test('login screen can be rendered', function () {
            $response = $this->get('/login');

            $response->assertStatus(200);
        });

        test('users can authenticate using the login screen', function () {
            $user = User::factory()->create();

            $response = $this->post('/login', [
                'email' => $user->email,
                'password' => 'password',
            ]);

            $this->assertAuthenticated();
            $response->assertRedirect(route('home', absolute: false));
        });

        test('users can not authenticate with invalid password', function () {
            $user = User::factory()->create();

            $this->post('/login', [
                'email' => $user->email,
                'password' => 'wrong-password',
            ]);

            $this->assertGuest();
        });

        test('users can logout', function () {
            $user = User::factory()->create();

            $response = $this->actingAs($user)->post('/logout');

            $this->assertGuest();
            $response->assertRedirect('/');
        });
    })->group('Success');

})->group('Authentication');
