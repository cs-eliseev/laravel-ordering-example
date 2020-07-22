<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Response;

/**
 * Class AjaxMiddleware
 *
 * @description
 */
class AjaxMiddleware extends Middleware
{
    public function handle($request, Closure $next, ...$guards)
    {
        if ( ! $request->ajax() ) {
            return abort(Response::HTTP_NOT_FOUND);
        }

        return $next($request);
    }
}
