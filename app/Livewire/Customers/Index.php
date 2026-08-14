<?php

namespace App\Livewire\Customers;

use App\Models\Customer;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\{Attributes\Computed, Component, WithPagination};

/**
 * @class Customers\Index
 * @author BrunoDeBrito @email <brunordebrito@gmail.com>
 * @since 8/13/26 15:14
 * @version 1.0.0
 *
 * @property-read LengthAwarePaginator|Customer[] $customers
 * @property-read array $headers
 */
class Index extends Component
{
    use WithPagination;

    public ?string $search = null;

    public ?string $sortColumnBy = 'id';

    public ?string $sortDirection = 'asc';

    public int $perPage = 15;

    public function render(): View
    {
        return view('livewire.cutomers.index');
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
                'key'           => 'actions',
                'label'         => 'Actions',
                'sortColumnBy'  => null,
                'sortDirection' => null,
            ],
        ];
    }

    #[Computed]
    public function customers(): LengthAwarePaginator
    {
        return Customer::query()
            ->when($this->search, function (Builder $q) {
                $q->where('name', 'like', "%{$this->search}%")
                    ->orWhere('email', 'like', "%{$this->search}%");
            })
            ->orderBy($this->sortColumnBy, $this->sortDirection)
            ->paginate($this->perPage);
    }
}
