<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

/**
 * @class HasSearch
 * @author BrunoDeBrito @email <brunordebrito@gmail.com>
 * @since 8/14/26 15:51
 * @version 1.0.0
 *
 */
trait HasSearch
{
    public function scopeSearch(Builder $query, string $search = null, ?array $columns = []): Builder
    {
        return $query->where(function (Builder $q) use ($search, $columns) {
            if ($search && $columns) {
                $sch = strtolower($search);

                foreach ($columns as $column) {
                    $q->orWhere(
                        DB::raw("lower({$column})"), /** @phpstan-ignore-line */
                        'like',
                        "%{$sch}%"
                    );
                }
            }
        });

    }
}
