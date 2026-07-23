<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use App\Notifications\UserRestoredAccessNotification;
use Illuminate\View\View;
use Livewire\Attributes\{On, Rule};
use Livewire\Component;
use Mary\Traits\Toast;

/**
 * @class Restore
 * @author BrunoDeBrito @email <brunordebrito@gmail.com>
 * @since 7/23/26 15:53
 * @version 1.0.0
 *
 */
class Restore extends Component
{
    use Toast;

    public ?User $user = null;

    #[Rule(['required', 'string', 'confirmed'])]
    public string $confirmation = "YODA";

    public ?string $confirmation_confirmation = null;

    public bool $modal = false;

    public function render(): View
    {
        return view('livewire.admin.users.restore');
    }

    #[On('user::restoring')]
    public function openConfirmationFor(int $userId): void
    {
        $this->modal = true;
        $this->user  = User::select('id', 'name', 'email')->withTrashed()->find($userId);
    }

    public function restore(): void
    {
        $this->validate();

        if ($this->user->is(auth()->user())) {
            $this->addError('confirmation', 'You cannot restore yourself.');

            $this->error('User not permission restored is user!');

            return;
        }

        $this->user->restore();

        $this->user->restored_at = now();
        $this->user->restored_by = auth()->user()->id;
        $this->user->save();

        $this->user->notify(new UserRestoredAccessNotification());

        $this->dispatch('user::restoring');

        $this->reset('modal', 'confirmation', 'confirmation_confirmation');
        $this->success('User restored successfully!');

    }
}
