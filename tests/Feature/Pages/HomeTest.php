<?php

use App\Models\User;

use function Pest\Laravel\actingAs;
use Tests\TestCase;


beforeAll(function () {
    // sign in
    actingAs(User::factory()->create());
});

beforeEach(function () {
});

describe("Home page", function () {
    it("Has home page", function () {
        $this->get(route("home"))
            ->assertSeeLivewire(Home::class);
    });
});
