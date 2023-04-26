<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasPermissionMiddleware
{
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        if (!$request->user()->hasPermissionTo($permission)) {
            return back();
        }

        return $next($request);
    }
}
