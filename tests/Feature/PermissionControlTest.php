<?php

use App\Models\{Can, Permission, User};
use Database\Seeders\{
    PermissionSeeder,
    UserSeeder
};
use Illuminate\Support\Facades\{Cache, DB};

use function Pest\Laravel\{
    actingAs,
    assertDatabaseHas,
    get,
    seed
};

it('should be able to give an user a permission to do something.', function () {

    /** @var User $user */
    $user = User::factory()->create();

    $user->givePermissionTo(Can::BE_AN_ADMIN->value);

    expect($user)
        ->hasPermissionTo(Can::BE_AN_ADMIN)
    ->toBeTrue();

    assertDatabaseHas('permissions', [
        'key' => Can::BE_AN_ADMIN->value,
    ]);

    assertDatabaseHas('permission_user', [
        'user_id'       => $user->id,
        'permission_id' => Permission::where('key', Can::BE_AN_ADMIN->value)
            ->first()
            ->id,
    ]);

});

test('permission has to have a seeder', function () {
    $this->seed(PermissionSeeder::class);

    assertDatabaseHas('permissions', [
        'key' => Can::BE_AN_ADMIN,
    ]);

});

test('seed with an admin user', function () {
    seed([PermissionSeeder::class, UserSeeder::class]);

    assertDatabaseHas('permissions', [
        'key' => Can::BE_AN_ADMIN->value,
    ]);

    assertDatabaseHas('permission_user', [
        'user_id'       => User::first()?->id,
        'permission_id' => Permission::where('key', Can::BE_AN_ADMIN->value)
            ->first()
            ->id,
    ]);

});

it('should block a access the access to an admin page if the user does not have the permission to be an admin.', function () {
    $user = User::factory()->create();

    actingAs($user)
        ->get(route('admin.dashboard'))
    ->assertForbidden();
});

test('Let is make sure that we are using chace to store user permission', function () {
    $user = User::factory()->create();

    $user->givePermissionTo(Can::BE_AN_ADMIN->value);

    $cacheKey = "user::{$user->id}::permissions";

    expect(Cache::has($cacheKey))
        ->toBeTrue('Checking if cache key exists')
        ->and(Cache::get($cacheKey))
        ->toBe($user->permissions);
});

test('Let is make sure that we are using the cache the retrieve/check when the user has given permission.', function () {
    $user = User::factory()->create();

    $user->givePermissionTo(Can::BE_AN_ADMIN->value);

    DB::listen(fn () => throw new Exception('We got a hit'));
    $user->hasPermissionTo(Can::BE_AN_ADMIN->value);

    expect(true)->toBeTrue();
});
