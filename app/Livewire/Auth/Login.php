<?php

namespace App\Livewire\Auth;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\{Factory, View as ViewInstance};
use Illuminate\Foundation\Application as ApplicationInstance;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Component;

class Login extends Component
{
    public ?string $email;

    public ?string $password;

    public function render(): Factory|ApplicationInstance|ViewInstance|View|Application
    {
        return view('livewire.auth.login');
    }

    public function tryToLogin(): void
    {
        if (!Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
            return;
        }

        $this->redirect(route('dashboard'));
    }
}
