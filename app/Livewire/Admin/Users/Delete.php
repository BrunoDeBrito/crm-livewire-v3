<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Illuminate\View\View;
use Livewire\Attributes\Rule;
use Livewire\Component;

/**
 * @class Delete
 * @author BrunoDeBrito @email <brunordebrito@gmail.com>
 * @since 7/22/26 15:56
 * @version 1.0.0
 *
 */
class Delete extends Component
{
    public User $user;

    #[Rule(['required', 'string', 'confirmed'])]
    public string $confirmation = "DART VADER";

    public ?string $confirmation_confirmation = null;

    public function render(): View
    {
        return view('livewire.admin.users.delete');
    }

    public function destroy(): void
    {
        $this->validate();
        $this->user->delete();

        $this->dispatch('user::deleted');
    }
}
