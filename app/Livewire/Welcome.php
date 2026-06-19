<?php

namespace App\Livewire;

use Livewire\Component;

/**
 * @class Welcome
 * @package App\Livewire
 * @author BrunoDeBrito <brunordebrito@gmail.com>
 * @since 6/18/26 22:59
 * @version 1.0.0
 *
 */
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
