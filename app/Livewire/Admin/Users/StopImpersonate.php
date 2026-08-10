<?php

namespace App\Livewire\Admin\Users;

use Illuminate\View\View;
use Livewire\Component;

/**
 * @class StopImpersonate
 * @author BrunoDeBrito @email <brunordebrito@gmail.com>
 * @since 8/10/26 16:42
 * @version 1.0.0
 *
 */
class StopImpersonate extends Component
{
    public function render(): View
    {
        return view('livewire.admin.users.stop-impersonate', [
            'user' => auth()->user(),
        ]);
    }

    public function stop(): void
    {
        session()->forget('impersonate');

        $this->redirect(route('admin.users'));
    }
}
