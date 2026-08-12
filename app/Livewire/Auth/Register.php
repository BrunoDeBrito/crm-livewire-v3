<?php

namespace App\Livewire\Auth;

use App\Models\User;
use App\Notifications\WelcomeNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Event;
use Livewire\Attributes\{Layout, Rule};
use Livewire\Component;

/**
 * @class Register
 * @author BrunoDeBrito <brunordebrito@gmail.com>
 * @since 6/6/26 21:53
 * @version 1.0.0
 *
 */
class Register extends Component
{
    #[Rule(['required', 'max:255'])]
    public ?string $name = null;

    #[Rule(['required', 'email', 'max:255', 'confirmed', 'unique:users,email'])]
    public ?string $email = null;

    public ?string $email_confirmation = null;

    #[Rule(['required'])]
    public ?string $password = null;

    #[Layout('components.layouts.guest')]
    public function render(): View
    {
        return view('livewire.auth.register');
    }

    public function submit(): void
    {
        $this->validate();

        /** @var User $user */
        $user = User::query()->create([
            'name'     => $this->name,
            'email'    => $this->email,
            'password' => $this->password,
        ]);

        auth()->login($user);

        $user->notify(new WelcomeNotification());

        Event::dispatch(new Registered($user));

        $this->redirect(route('auth.email-validation'));
    }
}
