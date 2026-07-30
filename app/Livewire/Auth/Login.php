<?php

namespace App\Livewire\Auth;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\{Auth, RateLimiter};
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Component;

/**
 * @class Login
 * @author BrunoDeBrito <brunordebrito@gmail.com>
 * @since 6/18/26 22:59
 * @version 1.0.0
 *
 */
class Login extends Component
{
    public ?string $email;

    public ?string $password;

    #[Layout('components.layouts.guest')]
    public function render(): View
    {
        return view('livewire.auth.login');
    }

    public function tryToLogin(): void
    {
        $email = Str::lower($this->email);

        if(RateLimiter::tooManyAttempts($email, 5)) {
            $this->addError('rateLimiter', trans('auth.throttle', [
                'seconds' => RateLimiter::availableIn($email),
            ]));

            return;
        }

        if (!Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
            RateLimiter::hit($email);
            $this->addError('invalidCredentials', trans('auth.failed'));

            return;
        }

        $this->redirect(route('dashboard'));
    }
}
