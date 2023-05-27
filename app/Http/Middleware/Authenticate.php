<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request, $guard)
    {
        switch ($guard) {
            case 'client':
                return $request->expectsJson() ? null : route('site_login_form');
                break;
            default:
                return $request->expectsJson() ? null : route('form_login');
                break;
        }
    }
}
