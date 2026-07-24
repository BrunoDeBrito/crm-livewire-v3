<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Livewire\Component;

/**
 * @class Show
 * @author BrunoDeBrito @email <brunordebrito@gmail.com>
 * @since 7/24/26 13:03
 * @version 1.0.0
 *
 */
class Show extends Component
{
    public ?User $user = null;

    public bool $modal = false;

    public function render(): View
    {
        return view('livewire.admin.users.show');
    }

    public function loadUser(int $id): void
    {
        $this->user  = User::withTrashed()->find($id);
        $this->modal = true;
    }
}
