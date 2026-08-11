<?php

use App\Livewire\Dev\Login;
use App\Models\User;

use function Pest\Laravel\assertAuthenticatedAs;

it('should be able to list users all users of the system.', function () {
    User::factory()->count(10)->create();

    $users = User::all();

    Livewire::test(Login::class)
        ->assertSet('users', $users)
        ->assertSee($users->first()->name);
});

it('should be able to log in with any user.', function () {
    $user = User::factory()->create();

    Livewire::test(Login::class)
        ->set('selectedUser', $user->id)
        ->call('login')
        ->assertRedirect(route('dashboard'));

    assertAuthenticatedAs($user);
});
