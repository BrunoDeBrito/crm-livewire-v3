<?php

namespace App\Traits;

use App\Support\Table\{Header};
use Illuminate\Support\Collection;

/**
 * @class HasTable
 *
 * @author BrunoDeBrito @email <brunordebrito@gmail.com>
 *
 * @since 8/17/26 13:51
 *
 * @version 1.0.0
 */
trait HasTable
{
    public ?string $search = null;

    public Collection $permissionsToSearch;

    public array $search_permissions = [];

    public ?string $sortColumnBy = 'id';

    public ?string $sortDirection = 'asc';

    public bool $search_trash = false;

    public int $perPage = 15;

    abstract public function tableHeaders(): array;

    /** @return Column[] */
    public function headers(): array
    {
        return collect($this->tableHeaders())
            ->map(function (Header $header) {
                return [
                    'key'           => $header->key,
                    'label'         => $header->label,
                    'sortColumnBy'  => $header->sortColumnBy,
                    'sortDirection' => $header->sortDirection,
                ];
            })->toArray();
    }
}
