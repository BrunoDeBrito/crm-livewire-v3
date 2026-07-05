<?php

use App\Livewire\Auth\Password;
use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Livewire\Livewire;

use function Pest\Laravel\get;

test('need to receive a valid token with a combination with the email', function () {
    Notification::fake();

    $user = User::factory()->create();

    Livewire::test(Password\Recovery::class)
        ->set('email', $user->email)
        ->call('startPasswordRecovery');

    Notification::assertSentTo(
        $user,
        ResetPassword::class,
        function (ResetPassword $item) {
            get(route('password.reset') . '?token=' . $item->token)
                ->assertSuccessful();

            get(route('password.reset') . '?token=any_token')
                ->assertRedirect(route('login'));

            return true;
        }
    );

});
