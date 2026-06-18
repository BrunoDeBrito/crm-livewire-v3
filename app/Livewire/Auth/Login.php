<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\{Auth, RateLimiter};
use Illuminate\Support\Str;
use Livewire\Component;

class Login extends Component
{
    public ?string $email;

    public ?string $password;

    public function render()
    {
        return view('livewire.auth.login')
            ->layout('components.layouts.guest');
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
