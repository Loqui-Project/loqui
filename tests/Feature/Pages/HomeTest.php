<?php

declare(strict_types=1);

use App\Models\User;

use function Pest\Laravel\actingAs;

beforeAll(function () {
    actingAs(User::factory()->create());
});

beforeEach(function () {});

describe('Home page', function () {});
