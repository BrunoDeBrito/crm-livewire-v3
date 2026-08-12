<?php

namespace App\Livewire\Auth;

use App\Events\SendNewCode;
use App\Notifications\WelcomeNotification;
use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Contracts\View\View;
use Livewire\Component;

/**
 * @class EmailValidation
 *
 * @author BrunoDeBrito @email <brunordebrito@gmail.com>
 *
 * @since 8/12/26 17:12
 *
 * @version 1.0.0
 */
class EmailValidation extends Component
{
    public ?int $code = null;

    public function render(): View
    {
        return view('livewire.auth.email-validation');
    }

    public function handle(): void
    {
        $this->validate([
            'code' => function (string $attribute, mixed $value, Closure $fail) {
                if (auth()->user()->validation_code !== $value) {
                    $fail('Invalid Code');
                }
            },
        ]);

        $user                    = auth()->user();
        $user->validation_code   = null;
        $user->email_verified_at = now();

        $user->save();

        $user->notify(new WelcomeNotification());

        $this->redirect(RouteServiceProvider::HOME);
    }

    public function sendNewCode(): void
    {
        SendNewCode::dispatch(auth()->user());
    }
}
