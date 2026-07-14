<?php

namespace App\Providers;

use App\Models\{Can, User};
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

/**
 * @class AuthServiceProvider
 * @author BrunoDeBrito @email <brunordebrito@gmail.com>
 * @since 7/13/26 22:27
 * @version 1.0.0
 *
 */
class AuthServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        foreach(Can::cases() as $can) {
            Gate::define(
                str($can->value)
                    ->kebab()
                    ->toString(),
                fn (User $user) => $user->hasPermissionTo($can)
            );
        }

    }
}
