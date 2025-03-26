<?php

declare(strict_types=1);

use App\Enums\UserStatusEnum;
use App\Models\User;

uses(Illuminate\Foundation\Testing\RefreshDatabase::class);

describe('Security Controller', function () {

    test('security page is displayed', function () {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get(route('settings.security.edit'));

        $response->assertOk();
    });

    test('user can deactivated his account', function () {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->from(route('settings.security.edit'))
            ->put(route('settings.security.deactivate'), [
                'password' => 'password',
            ]);
        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('welcome', [
                'message' => 'Your account has been deactivated.',
            ]));
        $user = User::where('id', $user->id)->first();
        expect($user->status->value)->toBe(UserStatusEnum::DEACTIVATED->value);

    });

    test('user can delete their account', function () {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->delete(route('settings.security.destroy'), [
                'password' => 'password',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/');

        $this->assertGuest();
        expect($user->fresh())->toBeNull();
    });

    test('correct password must be provided to delete account', function () {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->from(route('settings.security.edit'))
            ->delete(route('settings.security.destroy'), [
                'password' => 'wrong-password',
            ]);

        $response
            ->assertSessionHasErrors('password')
            ->assertRedirect(route('settings.security.edit'));

        expect($user->fresh())->not->toBeNull();
    });
});
