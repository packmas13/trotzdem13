<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class OnlyOrgaTeam
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        abort_if(!$request->user() || !$request->user()->isOrga(), 403, 'Access denied. Orga members only');
        return $next($request);
    }
}
