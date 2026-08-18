<?php

namespace App\Livewire\Admin\Users;

use App\Enums\Can;
use App\Models\{Permission, User};
use App\Traits\HasTable;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\{Attributes\On, Component, WithPagination};

/**
 * @class Index
 * @author BrunoDeBrito @email <brunordebrito@gmail.com>
 * @since 7/16/26 10:31
 * @version 1.0.0
 *
 * @property-read Collection|User[] $items
 * @property-read array $headers
 */
class Index extends Component
{
    use WithPagination;
    use HasTable;

    public function mount(): void
    {
        $this->authorize(Can::BE_AN_ADMIN->value);
        $this->filterPermissions();
    }

    #[On('user::deleted')]
    #[On('user::restoring')]
    public function render(): View
    {
        return view('livewire.admin.users.index');
    }

    public function updatePerPage(): void
    {
        $this->resetPage();
    }

    #[Computed]
    public function items(): LengthAwarePaginator
    {
        $this->validate(['search_permissions' => 'exists:permissions,id']);
        $search = strtolower($this->search);

        return User::query()
            ->with('permissions')
            ->search($search, ['name', 'email'])
            ->when(
                $this->search_permissions,
                fn (Builder $q) => $q->whereHas('permissions', function (Builder $query) {
                    $query->whereIn('permissions.id', $this->search_permissions);
                })
            )
            ->when(
                $this->search_trash,
                fn (Builder $q) => $q->onlyTrashed()/** @phpstan-ignore-line */
            )
            ->orderBy($this->sortColumnBy, $this->sortDirection)
            ->paginate($this->perPage);
    }

    #[Computed]
    public function tableHeaders(): array
    {
        return [
            ['key' => 'id',          'label' => '#'],
            ['key' => 'name',        'label' => 'Name'],
            ['key' => 'email',       'label' => 'Email'],
            ['key' => 'permissions', 'label' => 'Permissions'],
            ['key' => 'actions',     'label' => 'Actions'],
        ];
    }

    #[Computed]
    public function filterPermissions(?string $value = null): void
    {
        $this->permissionsToSearch = Permission::query()
            ->when($value, fn (Builder $q) => $q->where('name', 'like', "%{$value}%"))
            ->orderBy('key')
            ->get();
    }

    public function sortBy(?string $column, ?string $direction): void
    {
        $this->sortColumnBy  = $column;
        $this->sortDirection = $direction;
    }

    public function destroy(int $id): void
    {
        $this->dispatch('user::deletion', userId: $id)->to('admin.users.delete');
    }

    public function impersonate(int $id): void
    {
        $this->dispatch('user::impersonation', userId: $id)->to('admin.users.impersonate');
    }

    public function restore(int $id): void
    {
        $this->dispatch('user::restoring', userId: $id)->to('admin.users.restore');
    }

    public function showUser(int $id): void
    {
        $this->dispatch('user::show', id: $id)->to('admin.users.show');
    }
}
