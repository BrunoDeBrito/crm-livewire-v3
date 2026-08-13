<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @class ShouldBeVerified
 *
 * @author BrunoDeBrito @email <brunordebrito@gmail.com>
 *
 * @since 8/12/26 22:20
 *
 * @version 1.0.0
 */
class ShouldBeVerified
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user()->hasVerifiedEmail()) {
            return to_route('auth.email-validation');
        }

        return $next($request);
    }
}
