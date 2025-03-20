<?php

use App\Enums\UserStatusEnum;
use App\Models\User;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

describe('Security Controller', function () {

    test('security page is displayed', function () {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get(route('security.edit'));

        $response->assertOk();
    });

    test('user can deactivated his account', function () {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->from(route('security.edit'))
            ->put(route('security.deactivate'), [
                'password' => 'password',
            ]);
        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('welcome'));
        $user = User::where('id', $user->id)->first();
        expect($user->status->value)->toBe(UserStatusEnum::DEACTIVATED->value);

    });

    test('user can delete their account', function () {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->delete(route('security.destroy'), [
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
            ->from(route('security.edit'))
            ->delete(route('security.destroy'), [
                'password' => 'wrong-password',
            ]);

        $response
            ->assertSessionHasErrors('password')
            ->assertRedirect(route('security.edit'));

        expect($user->fresh())->not->toBeNull();
    });
});
