<?php

use App\Models\User;

use function Pest\Laravel\{actingAs, get};

it('should be to access the route admin-users', function () {
    actingAs(
        User::factory()
            ->admin()
            ->create()
    );

    get(route('admin.users'))
        ->assertOk();
});

test('making sure that the route is protecte by the permission BE_AN_ADMIM', function () {
    actingAs(
        User::factory()->create()
    );

    get(route('admin.users'))
        ->assertForbidden();
});
