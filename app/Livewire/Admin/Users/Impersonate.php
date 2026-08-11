<?php

namespace App\Livewire\Admin\Users;

use App\Enums\Can;
use Exception;
use Livewire\Attributes\On;
use Livewire\Component;

class Impersonate extends Component
{
    public function render(): string
    {
        return <<<'HTML'
            <div />
        HTML;
    }

    #[On('user::impersonation')]
    public function impersonate($userId): void
    {
        $this->authorize(Can::BE_AN_ADMIN->value);

        if (auth()->id() === $userId) {
            throw new Exception(__("You can't impersonate yourself."));
        }

        session()->put('impersonator', auth()->id());
        session()->put('impersonate', $userId);

        $this->redirect(route('dashboard'));
    }
}
