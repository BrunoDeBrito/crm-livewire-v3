<?php

namespace App\Livewire\Auth;

use Livewire\Attributes\On;
use Livewire\Component;

/**
 * @class Logout
 * @author BrunoDeBrito <brunordebrito@gmail.com>
 * @since 6/18/26 22:59
 * @version 1.0.0
 *
 */
class Logout extends Component
{
    public function render(): string
    {
        return
        <<<BLADE
            <div />
        BLADE;
    }

    #[On('logout')]
    public function logout(): void
    {
        auth()->logout();

        session()->invalidate();
        session()->regenerateToken();

        $this->redirect(route('login'));
    }
}
