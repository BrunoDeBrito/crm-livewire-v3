<?php

use App\Enums\Can;
use App\Livewire\Admin;
use App\Models\{Permission, User};
use Livewire\Livewire;

use function Pest\Laravel\{actingAs, get};

it('should be to access the route admin-users', function () {
    actingAs(User::factory()->admin()->create());

    get(route('admin.users'))
        ->assertOk();
});

test('making sure that the route is protected by the permission BE_AN_ADMIN.', function () {
    actingAs(User::factory()->create());

    get(route('admin.users'))
        ->assertForbidden();
});

test('let is create a livewire componente to list all users in the page.', function () {
    actingAs(User::factory()->admin()->create());
    $users = User::factory()->count(10)->create();

    $lw = Livewire::test(Admin\Users\Index::class);

    $lw->assertSet('users', function ($users) {
        expect($users)
            ->toHaveCount(11);

        return true;
    });

    foreach ($users as $user) {
        $lw->assertSee($user->name);
    }
});

test('check the table format', function () {
    actingAs(User::factory()->admin()->create());

    Livewire::test(Admin\Users\Index::class)
        ->assertSet('headers', [
            ['key' => 'id', 'label' => '#'],
            ['key' => 'name', 'label' => 'Name'],
            ['key' => 'email', 'label' => 'Email'],
            ['key' => 'permissions', 'label' => 'Permissions'],
        ]);
});

it('should be able to filter by name and email', function () {
    $admin = User::factory()->admin()->create(
        [
            'name'  => 'Joe Doe',
            'email' => 'admin@gmail.com',
        ]
    );

    $mario = User::factory()->create(
        [
            'name'  => 'Mario Rossi',
            'email' => 'little_guy@example.com',
        ]
    );

    actingAs($admin);

    Livewire::test(Admin\Users\Index::class)
        ->assertSet('users', function ($users) {
            expect($users)
                ->toHaveCount(2);

            return true;
        })
        ->set('search', 'mar')
        ->assertSet('users', function ($users) use ($mario) {
            expect($users)
                ->toHaveCount(1)
                ->and($users->first()->name)->toBe($mario->name);

            return true;
        })
        ->set('search', 'guy')
        ->assertSet('users', function ($users) use ($mario) {
            expect($users)
                ->toHaveCount(1)
                ->and($users->first()->name)->toBe($mario->name);

            return true;
        });
});

it('should be able to filter by permission key', function () {
    $admin = User::factory()->admin()->create(
        [
            'name'  => 'Joe Doe',
            'email' => 'admin@gmail.com',
        ]
    );

    $nonAdmin = User::factory()->create(
        [
            'name'  => 'Mario Rossi',
            'email' => 'little_guy@example.com',
        ]
    );

    $permission = Permission::where('key', Can::BE_AN_ADMIN->value)->first();

    actingAs($admin);

    Livewire::test(Admin\Users\Index::class)
        ->assertSet('users', function ($users) {
            expect($users)
                ->toHaveCount(2);

            return true;
        })
        ->set('search_permissions', [$permission->id])
        ->assertSet('users', function ($users) use ($admin) {
            expect($users)
                ->toHaveCount(1)
                ->and($users->first()->name)->toBe($admin->name);

            return true;
        });
});
