<?php

namespace App\Livewire\Dev;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;

/**
 * @class Login
 *
 * @author BrunoDeBrito @email <brunordebrito@gmail.com>
 *
 * @since 8/10/26 23:32
 *
 * @version 1.0.0
 */
class Login extends Component
{
    public ?int $selectedUser = null;
    public function render(): View
    {
        return view('livewire.dev.login');
    }

    #[Computed]
    public function users(): Collection
    {
        return User::all();
    }

    public function login(): void
    {
        auth()->loginUsingId($this->selectedUser);

        $this->redirect(route('dashboard'));
    }
}
