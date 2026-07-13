<?php

namespace App\Models;

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

    public function givePermissionTo(string $key): void
    {
        $this->permissions()
            ->firstOrCreate(compact('key'));

        Cache::forget($this->getPermissionCacheKey());
        Cache::rememberForever(
            $this->getPermissionCacheKey(),
            fn () => $this->permissions
        );
    }

    public function hasPermissionTo(string $key): bool
    {
        /** @var Collection $permissions */
        $permissions = Cache::get(
            $this->getPermissionCacheKey(),
            $this->permissions
        );

        return $permissions
            ->where('key', $key)
            ->isNotEmpty();
    }

    public function getPermissionCacheKey(): string
    {
        return "user::{$this->id}::permissions";
    }

}
