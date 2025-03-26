<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

uses(Illuminate\Foundation\Testing\RefreshDatabase::class);

describe('Profile Update tests', function () {

    test('profile page is displayed', function () {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get(route('settings.profile.edit'));

        $response->assertOk();
    });

    test('profile information can be updated', function () {
        $user = User::factory()->create();
        Storage::fake('public');

        $response = $this
            ->actingAs($user)
            ->post(route('settings.profile.edit'), [
                'name' => 'Test User',
                'email' => 'test@example.com',
                'image' => $file = UploadedFile::fake()->image('post.jpg'),
            ]);

        $response
            ->assertSessionHasNoErrors()->assertRedirect(route('settings.profile.edit'));

        $user->refresh();

        expect($user->name)->toBe('Test User');
        expect($user->email)->toBe('test@example.com');
        expect($user->email_verified_at)->toBeNull();
    });

    test('email verification status is unchanged when the email address is unchanged', function () {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->post(route('settings.profile.edit'), [
                'name' => 'Test User',
                'email' => $user->email,
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('settings.profile.edit'));

        expect($user->refresh()->email_verified_at)->not->toBeNull();
    });

});
