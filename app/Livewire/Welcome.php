<?php

namespace App\Livewire;

use Livewire\Component;

class Welcome extends Component
{
    public function render(): string
    {
        return <<<'HTML'
        <div>
            Hello :)
        </div>
        HTML;
    }
}
