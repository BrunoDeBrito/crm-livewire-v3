<?php

use App\Listeners\Auth\CreateValidationCode;
use App\Livewire\Auth\{EmailValidation, Register};
use App\Models\User;
use App\Notifications\ValidationCodeNotification;
use Illuminate\Auth\Events\Registered;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;
use function PHPUnit\Framework\assertTrue;

beforeEach(function () {
    Notification::fake();
});

describe('After Registration', function () {
    it('should create a new validation code and save in the users table.', function () {
        $user = User::factory()->create([
            'email_verified_at' => null,
            'validation_code'   => null,
        ]);

        $event    = new Registered($user);
        $listener = new CreateValidationCode();

        $listener->handle($event);

        $user->refresh();

        expect($user->validation_code)->not->toBeNull()
            ->and($user->validation_code)->toBeNumeric();

        $strLen = str($user->validation_code)->length() === 6;

        assertTrue($strLen);
    });

    it('should send that new code to the user via email.', function () {
        $user = User::factory()->create([
            'email_verified_at' => null,
            'validation_code'   => null,
        ]);

        $event    = new Registered($user);
        $listener = new CreateValidationCode();

        $listener->handle($event);

        Notification::assertSentTo($user, ValidationCodeNotification::class);

    });

    test('making sure that the listener to send the code is linked to the Registered event.', function () {
        Event::fake();

        Event::assertListening(
            Registered::class,
            CreateValidationCode::class
        );
    });
});

describe('Validation Page', function () {
    it('should redirect to the validation page after registration.', function () {
        Livewire::test(Register::class)
            ->set('name', 'Joe Doe')
            ->set('email', 'joe@doe.com')
            ->set('email_confirmation', 'joe@doe.com')
            ->set('password', 'password')
            ->call('submit')
            ->assertHasNoErrors()
            ->assertRedirect(route('auth.email-validation'));
    });

    it('should check if the code is valid.', function () {
        $user = User::factory()->withValidationCode()->create();

        actingAs($user);

        Livewire::test(EmailValidation::class)
            ->set('code', 000000)
            ->call('handle')
            ->assertHasErrors('code');
    });
});
