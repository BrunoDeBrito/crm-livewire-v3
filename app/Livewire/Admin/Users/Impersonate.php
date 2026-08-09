<?php

namespace App\Livewire\Admin\Users;

use Livewire\Component;

class Impersonate extends Component
{
    public function render(): string
    {
        return <<<'HTML'
            <div />
        HTML;
    }

    public function impersonate($id): void
    {
        session()->put('impersonate', $id);
    }

}
