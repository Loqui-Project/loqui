<?php

declare(strict_types=1);

use App\Models\User;
use Laravel\Passport\ClientRepository;
use Laravel\Passport\Passport;

uses(Illuminate\Foundation\Testing\RefreshDatabase::class);

describe('Authentication', function () {
    describe('Validation', function () {
        test('Throw error when email is not provided', function () {
            $response = $this->postJson('/api/login', [
                'password' => fake()->password,
            ]);

            $response->assertStatus(422)->assertJson([
                'message' => 'The email field is required.',
                'errors' => [
                    'email' => ['The email field is required.'],
                ],
            ]);

        });
        test('Throw error when password is not provided', function () {
            $response = $this->postJson('/api/login', [
                'email' => fake()->email,
            ]);

            $response->assertStatus(422)->assertJson([
                'message' => 'The password field is required.',
                'errors' => [
                    'password' => ['The password field is required.'],
                ],
            ]);
        });
        test('Throw error when email is not valid', function () {
            $response = $this->postJson('/api/login', [
                'email' => 'invalid-email',
                'password' => 'password',
            ]);

            $response->assertStatus(422)->assertJson([
                'message' => 'The email field must be a valid email address.',
                'errors' => [
                    'email' => ['The email field must be a valid email address.'],
                ],
            ]);
        });

        test('Throw error when user is not found', function () {
            $response = $this->postJson('/api/login', [
                'email' => fake()->email,
                'password' => 'password',
            ]);

            $response->assertStatus(422)->assertJson([
                'message' => 'These credentials do not match our records.',
            ]);
        });
    })->group('Validation');
    describe('Success', function () {
        beforeEach(function () {
            // delete all clients
            Illuminate\Support\Facades\DB::table('oauth_clients')->truncate();

            $clients = app(ClientRepository::class);
            $client = $clients->createPersonalAccessClient(
                null, 'Test password grant token', 'http://localhost'
            );
            config(['services.passport_client.client_id' => $client->id]);
            config(['services.passport_client.client_secret' => $client->secret]);
        });
        test('users can authenticate using the login api', function () {
            $user = User::factory()->create();
            Passport::actingAs($user, ['*']);
            $response = $this->postJson('/api/login', [
                'email' => $user->email,
                'password' => 'password',
            ]);
            $response->assertStatus(200)->assertJson([
                'message' => 'Login successful',
                'access_token' => true,
            ]);

        });

        test('users can not authenticate with invalid password', function () {
            $user = User::factory()->create();

            $response = $this->postJson('/api/login', [
                'email' => $user->email,
                'password' => 'wrong-password',
            ]);

            $this->assertGuest();
        });

        test('users can logout', function () {
            $user = User::factory()->create();

            $response = $this->actingAs($user)->postJson('/api/logout');

            $this->assertGuest();
        });
    })->group('Success');

})->group('Authentication');
