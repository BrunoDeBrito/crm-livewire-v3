<?php

use App\Livewire\Admin;
use App\Models\User;
use Livewire\Livewire;

use function Pest\Laravel\{actingAs, get};
use function PHPUnit\Framework\{assertSame, assertTrue};

it('should add key impersonate to the session with the given user.', function () {
    $user = User::factory()->create();

    Livewire::test(Admin\Users\Impersonate::class)
        ->call('impersonate', $user->id);

    assertTrue(session()->has('impersonate'));

    assertSame(session()->get('impersonate'), $user->id);
});

it('should make sure that we are logged with the impersonated user.', function () {
    $admin = User::factory()->admin()->create();
    $user  = User::factory()->create();

    actingAs($admin);

    Livewire::test(Admin\Users\Impersonate::class)
        ->call('impersonate', $user->id);

    get(route('dashboard'))
        ->assertSee(__("You are impersonating :name, click here to stop the impersonation.", ['name' => $user->name]));

    expect(auth()->user()->id)->toBe($user->id);
});
