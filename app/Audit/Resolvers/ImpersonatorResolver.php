<?php

namespace App\Audit\Resolvers;

use OwenIt\Auditing\Contracts\{Auditable, Resolver};

/**
 * @class ImpersonatorResolver
 * @author BrunoDeBrito @email <brunordebrito@gmail.com>
 * @since 8/10/26 18:25
 * @version 1.0.0
 *
 */
class ImpersonatorResolver implements Resolver
{
    public static function resolve(Auditable $auditable): mixed
    {
        return session('impersonator');

    }

}
