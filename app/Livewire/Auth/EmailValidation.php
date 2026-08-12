<?php

namespace App\Livewire\Auth;

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
    public ?string $code = null;

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
    }
}
