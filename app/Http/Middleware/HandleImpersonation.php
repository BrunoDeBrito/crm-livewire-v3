<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @class HandleImpersonation
 * @author BrunoDeBrito @email <brunordebrito@gmail.com>
 * @since 8/9/26 16:45
 * @version 1.0.0
 *
 */
class HandleImpersonation
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($id = session('impersonate')) {
            auth()->onceUsingId($id);
        }

        return $next($request);
    }
}
