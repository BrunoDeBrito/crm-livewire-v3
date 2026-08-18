<?php

namespace App\Livewire\Customers;

use App\Models\Customer;
use App\Support\Table\Column;
use App\Traits\HasTable;
use Illuminate\Contracts\View\View;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\{Attributes\Computed, Component, WithPagination};

/**
 * @class Customers\Index
 *
 * @author BrunoDeBrito @email <brunordebrito@gmail.com>
 *
 * @since 8/13/26 15:14
 *
 * @version 1.0.0
 *
 * @property-read LengthAwarePaginator|Customer[] $items
 * @property-read array $headers
 */
class Index extends Component
{
    use HasTable;
    use WithPagination;

    public function render(): View
    {
        return view('livewire.customers.index');
    }

    #[Computed]
    public function items(): LengthAwarePaginator
    {
        return Customer::query()
            ->search($this->search, ['name', 'email'])
            ->orderBy($this->sortColumnBy, $this->sortDirection)
            ->paginate($this->perPage);
    }

    public function tableHeaders(): array
    {
        return [
            Column::make('id', '#'),
            Column::make('name', 'Name'),
            Column::make('email', 'Email'),
            Column::make('action', 'Actions'),
        ];
    }
}
