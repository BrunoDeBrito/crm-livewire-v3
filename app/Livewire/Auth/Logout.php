<?php

namespace App\Livewire\Auth;

use Livewire\Component;

/**
 * @class Logout
 * @package App\Livewire\Auth
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
            <div>
                <x-button icon="o-power"
                    class="btn-circle btn-ghost btn-xs"
                    wire:click="logout"
                />
            </div>
        BLADE;
    }

    public function logout(): void
    {
        auth()->logout();

        session()->invalidate();
        session()->regenerateToken();

        $this->redirect(route('login'));
    }
}
