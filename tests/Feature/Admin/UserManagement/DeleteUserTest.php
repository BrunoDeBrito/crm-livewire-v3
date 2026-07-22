<?php

use App\Livewire\Admin;
use App\Models\{User};
use App\Notifications\UserDeletedNotification;
use Illuminate\Support\Facades\Notification;
use Livewire\Livewire;

use function Pest\Laravel\{actingAs, assertNotSoftDeleted, assertSoftDeleted};

it('should be able to delete a user', function () {
    $user      = User::factory()->admin()->create();
    $forDelete = User::factory()->create();

    actingAs($user);

    Livewire::test(Admin\Users\Delete::class, ['user' => $forDelete])
        ->set('confirmation_confirmation', 'DART VADER')
        ->call('destroy')
        ->assertDispatched('user::deleted');

    assertSoftDeleted('users', ['id' => $forDelete->id]);
});

it('should have a confirmation before deletion', function () {
    $user      = User::factory()->admin()->create();
    $forDelete = User::factory()->create();

    actingAs($user);

    Livewire::test(Admin\Users\Delete::class, ['user' => $forDelete])
        ->call('destroy')
        ->assertHasErrors(['confirmation' => 'confirmed'])
        ->assertNotDispatched('user::deleted');

    assertNotSoftDeleted('users', ['id' => $forDelete->id]);
});

it('should send a notification to the user telling that he has no long access to the application', function () {
    Notification::fake();

    $user      = User::factory()->admin()->create();
    $forDelete = User::factory()->create();

    actingAs($user);

    Livewire::test(Admin\Users\Delete::class, ['user' => $forDelete])
        ->set('confirmation_confirmation', 'DART VADER')
        ->call('destroy');

    Notification::assertSentTo($forDelete, UserDeletedNotification::class);
});
