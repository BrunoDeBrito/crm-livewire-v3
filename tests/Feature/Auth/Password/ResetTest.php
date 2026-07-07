<?php

use App\Livewire\Auth\Password;
use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Livewire\Livewire;

use function Pest\Laravel\get;
use function PHPUnit\Framework\assertTrue;

test('need to receive a valid token with a combination with the email and open the page', function () {
    Notification::fake();

    $user = User::factory()->create();

    Livewire::test(Password\Recovery::class)
        ->set('email', $user->email)
        ->call('startPasswordRecovery');

    Notification::assertSentTo(
        $user,
        ResetPassword::class,
        static function (ResetPassword $item) {
            get(route('password.reset') . '?token=' . $item->token)
                ->assertSuccessful();

            get(route('password.reset') . '?token=any_token')
                ->assertRedirect(route('login'));

            return true;
        }
    );
});

test('if is possible to reset the password with the given token.', function () {
    Notification::fake();

    $user = User::factory()->create();

    Livewire::test(Password\Recovery::class)
        ->set('email', $user->email)
        ->call('startPasswordRecovery');

    Notification::assertSentTo(
        $user,
        ResetPassword::class,
        static function (ResetPassword $item) use ($user) {
            Livewire::test(Password\Reset::class, [
                'token' => $item->token,
                'email' => $user->email,
            ])
                ->set('email_confirmation', $user->email)
                ->set('password', 'new-password')
                ->set('password_confirmation', 'new-password')
                ->call('updatePassword')
                ->assertHasNoErrors()
                ->assertRedirect(route('login'));

            $user->refresh();

            assertTrue(Hash::check('new-password', $user->password));

            return true;
        }
    );
});

it('checking form rules', function ($field, $value, $rule) {
    Notification::fake();

    $user = User::factory()->create();

    Livewire::test(Password\Recovery::class)
        ->set('email', $user->email)
        ->call('startPasswordRecovery');

    Notification::assertSentTo(
        $user,
        ResetPassword::class,
        static function (ResetPassword $item) use ($user, $field, $value, $rule) {
            Livewire::test(Password\Reset::class, ['token' => $item->token, 'email' => $user->email])
                ->set($field, $value)
                ->call('updatePassword')
                ->assertHasErrors([$field => $rule]);

            return true;
        }
    );

})
    ->with([
        'email:required'     => ['field' => 'email', 'value' => '', 'rule' => 'required'],
        'email:confirmed'    => ['field' => 'email', 'value' => 'email@example.com', 'rule' => 'confirmed'],
        'email:email'        => ['field' => 'email', 'value' => 'not-an-email', 'rule' => 'email'],
        'password:required'  => ['field' => 'password', 'value' => '', 'rule' => 'required'],
        'password:confirmed' => ['field' => 'password', 'value' => 'any-password', 'rule' => 'confirmed'],
    ]);

test('needs to show obfuscate email to the user', function () {
    $email = 'jeremias@example.com';

    $obfuscatedEmail = obfuscate_email($email);

    expect($obfuscatedEmail)
        ->toBe('je******@********.com');

    Notification::fake();

    $user = User::factory()->create();

    Livewire::test(Password\Recovery::class)
        ->set('email', $user->email)
        ->call('startPasswordRecovery');

    Notification::assertSentTo(
        $user,
        ResetPassword::class,
        static function (ResetPassword $item) use ($user) {
            Livewire::test(Password\Reset::class, ['token' => $item->token, 'email' => $user->email])
                ->assertSet('obfuscatedEmail', obfuscate_email($user->email))
                ->call('updatePassword');

            return true;
        }
    );
});
