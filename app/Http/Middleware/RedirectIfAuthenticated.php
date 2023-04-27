<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $permissions = [
                    ['name' => 'dashboard', 'route' => 'control_panel'],
                    ['name' => 'view_delivery', 'route' => 'delivery'],
                    ['name' => 'view_orders', 'route' => 'requests'],
                    ['name' => 'view_tables', 'route' => 'tables'],
                    ['name' => 'config_users', 'route' => 'users'],
                    ['name' => 'config_app', 'route' => 'app_settings'],
                    ['name' => 'config_site', 'route' => 'site_settings'],
                ];
                foreach ($permissions as $permission) {
                    if (Auth::user()->hasPermissionTo($permission['name'])) {
                        return redirect()->route($permission['route']);
                    }
                }

            }
        }

        return $next($request);
    }
}
