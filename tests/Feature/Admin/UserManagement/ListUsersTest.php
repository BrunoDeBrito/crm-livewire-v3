<?php

use App\Livewire\Admin;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Livewire;

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

test('making sure that the route is protecte by the permission BE_AN_ADMIM.', function () {
    actingAs(
        User::factory()->create()
    );

    get(route('admin.users'))
        ->assertForbidden();
});

it('let is create a livewire componente to list all users in the page.', function () {
    $users = User::factory()->count(10)->create();

    $lw = Livewire::test(Admin\Users\Index::class);

    $lw->assertSet('users', function ($users) {
        expect($users)
            ->toBeInstanceOf(LengthAwarePaginator::class)
            ->toHaveCount(10);

        return true;
    });

    foreach ($users as $user) {
        $lw->assertSee($user->name);
    }

});
