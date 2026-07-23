<?php

use App\Livewire\Admin;
use App\Models\{User};
use App\Notifications\UserRestoredAccessNotification;
use Illuminate\Support\Facades\Notification;
use Livewire\Livewire;

use function Pest\Laravel\{actingAs, assertNotSoftDeleted, assertSoftDeleted};

it('should be able to restore a user', function () {
    $user       = User::factory()->admin()->create();
    $forRestore = User::factory()->deleted()->create();

    actingAs($user);

    Livewire::test(Admin\Users\Restore::class)
        ->set('user', $forRestore)
        ->set('confirmation_confirmation', 'YODA')
        ->call('restore')
        ->assertDispatched('user::restoring');

    assertNotSoftDeleted('users', ['id' => $forRestore->id]);
});

it('should have a confirmation before deletion', function () {
    $user       = User::factory()->admin()->create();
    $forRestore = User::factory()->deleted()->create();

    actingAs($user);

    Livewire::test(Admin\Users\Restore::class)
        ->set('user', $forRestore)
        ->call('restore')
        ->assertHasErrors(['confirmation' => 'confirmed'])
        ->assertNotDispatched('user::deleted');

    assertSoftDeleted('users', ['id' => $forRestore->id]);
});

it('should send a notification to the user telling that he has again access to the application', function () {
    Notification::fake();

    $user       = User::factory()->admin()->create();
    $forRestore = User::factory()->deleted()->create();

    actingAs($user);

    Livewire::test(Admin\Users\Restore::class)
        ->set('user', $forRestore)
        ->set('confirmation_confirmation', 'YODA')
        ->call('restore');

    Notification::assertSentTo($forRestore, UserRestoredAccessNotification::class);
});
