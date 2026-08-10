<?php

namespace App\Livewire\Admin\Users;

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
        session()->put('impersonate', $userId);

        $this->redirect(route('dashboard'));
    }

}
