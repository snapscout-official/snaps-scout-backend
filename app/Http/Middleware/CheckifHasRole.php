<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckifHasRole
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        //middleware that checks if the user currently requesting has a role
        //that is passed to the argument of the middleware
        if (!$request->user()  || !$request->user()->hasRole($role)) {
            abort(403);
        }
        return $next($request);
    }
}
