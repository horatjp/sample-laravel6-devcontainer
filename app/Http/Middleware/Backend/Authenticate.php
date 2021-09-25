<?php

namespace App\Http\Middleware\Backend;

use Closure;
use Illuminate\Support\Facades\Auth;

class Authenticate
{

    public function handle($request, Closure $next, $guard = null)
    {

        if (Auth::guard($guard)->guest()) {
            return redirect('backend/login');
        }

        return $next($request);
    }
}
