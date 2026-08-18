<?php

namespace App\Traits;

use App\Enums\Can;
use App\Models\Permission;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Cache;

/**
 * @class HasPermission
 * @author BrunoDeBrito @email <brunordebrito@gmail.com>
 * @since 7/13/26 18:37
 * @version 1.0.0
 *
 */
trait HasPermissions
{
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class);
    }

    public function givePermissionTo(Can|string $key): void
    {
        $pKey = $key instanceof Can ? $key->value : $key;

        $this->permissions()
            ->firstOrCreate(['key' => $pKey]);

        Cache::forget($this->getPermissionCacheKey());
        Cache::rememberForever(
            $this->getPermissionCacheKey(),
            fn () => $this->permissions
        );
    }

    public function hasPermissionTo(Can|string $key): bool
    {
        $pKey = $key instanceof Can ? $key->value : $key;

        /** @var Collection $permissions */
        $permissions = Cache::get(
            $this->getPermissionCacheKey(),
            fn () => $this->permissions
        );

        return $permissions
            ->where('key', $pKey)
            ->isNotEmpty();
    }

    public function getPermissionCacheKey(): string
    {
        return "user::{$this->id}::permissions";
    }
}
