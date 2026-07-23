<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use App\Notifications\UserDeletedNotification;
use Illuminate\View\View;
use Livewire\Attributes\{On, Rule};
use Livewire\Component;
use Mary\Traits\Toast;

/**
 * @class Delete
 * @author BrunoDeBrito @email <brunordebrito@gmail.com>
 * @since 7/22/26 15:56
 * @version 1.0.0
 *
 */
class Delete extends Component
{
    use Toast;

    public ?User $user = null;

    #[Rule(['required', 'string', 'confirmed'])]
    public string $confirmation = "DART VADER";

    public ?string $confirmation_confirmation = null;

    public bool $modal = false;

    public function render(): View
    {
        return view('livewire.admin.users.delete');
    }

    #[On('user::deletion')]
    public function openConfirmationFor(int $userId): void
    {
        $this->modal = true;
        $this->user  = User::select('id', 'name', 'email')->find($userId);
    }

    public function destroy(): void
    {
        $this->validate();

        if ($this->user->is(auth()->user())) {
            $this->addError('confirmation', 'You cannot delete yourself.');

            $this->error('User not permission deleted is user!');

            return;
        }

        $this->user->delete();

        $this->user->deleted_by = auth()->user()->id;
        $this->user->save();

        $this->user->notify(new UserDeletedNotification());

        $this->dispatch('user::deleted');

        $this->reset('modal', 'confirmation', 'confirmation_confirmation');
        $this->success('User deleted successfully!');

    }
}
