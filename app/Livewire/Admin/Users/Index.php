<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Component;

/**
 * @class Index
 * @author BrunoDeBrito @email <brunordebrito@gmail.com>
 * @since 7/16/26 10:31
 * @version 1.0.0
 * @property-read LengthAwarePaginator|User[] $users
 */
class Index extends Component
{
    public function render(): View
    {
        return view('livewire.admin.users.index');
    }

    #[Computed]
    public function users(): LengthAwarePaginator
    {
        return User::paginate();
    }
}
