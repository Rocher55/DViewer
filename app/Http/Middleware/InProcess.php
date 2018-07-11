<?php

namespace App\Http\Middleware;

use Closure;

class InProcess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $requestedPATH = str_replace(url('/'), '', $next);
        return $next($request);
    }
}
