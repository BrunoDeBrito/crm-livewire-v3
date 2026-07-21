<?php

namespace App\Livewire\Admin\Users;

use App\Enums\Can;
use App\Models\{Permission, User};
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\{Component, WithPagination};

/**
 * @class Index
 * @author BrunoDeBrito @email <brunordebrito@gmail.com>
 * @since 7/16/26 10:31
 * @version 1.0.0
 * @property-read Collection|User[] $users
 * @property-read array $headers
 */
class Index extends Component
{
    use WithPagination;

    public ?string $search = null;

    public Collection $permissionsToSearch;

    public array $search_permissions = [];

    public ?string $sortColumnBy = 'id';

    public ?string $sortDirection = 'asc';

    public bool $search_trash = false;

    public int $perPage = 15;

    public function mount(): void
    {
        $this->authorize(Can::BE_AN_ADMIN->value);
        $this->filterPermissions();
    }

    public function render(): View
    {
        return view('livewire.admin.users.index');
    }

    public function updatePerPage(): void
    {
        $this->resetPage();
    }

    #[Computed]
    public function users(): LengthAwarePaginator
    {
        $this->validate(['search_permissions' => 'exists:permissions,id']);
        $search = strtolower($this->search);

        return User::query()
            ->with('permissions')
            ->when(
                $this->search,
                function (Builder $q) use ($search) {
                    $q->where(
                        DB::raw('lower(name)'), /** @phpstan-ignore-line */
                        'like',
                        "%{$search}%"
                    )
                        ->orWhere(
                            'email',
                            'like',
                            "%{$search}%"
                        );
                }
            )
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
    public function headers(): array
    {
        return [
            [
                'key'           => 'id',
                'label'         => '#',
                'sortColumnBy'  => $this->sortColumnBy,
                'sortDirection' => $this->sortDirection,
            ],
            [
                'key'           => 'name',
                'label'         => 'Name',
                'sortColumnBy'  => $this->sortColumnBy,
                'sortDirection' => $this->sortDirection,
            ],
            [
                'key'           => 'email',
                'label'         => 'Email',
                'sortColumnBy'  => $this->sortColumnBy,
                'sortDirection' => $this->sortDirection,
            ],
            [
                'key'           => 'permissions',
                'label'         => 'Permissions',
                'sortColumnBy'  => $this->sortColumnBy,
                'sortDirection' => $this->sortDirection,
            ],
            [
                'key'           => 'actions',
                'label'         => 'Actions',
                'sortColumnBy'  => $this->sortColumnBy,
                'sortDirection' => $this->sortDirection,
            ],
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
}
