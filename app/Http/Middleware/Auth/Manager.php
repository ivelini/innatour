<?php

namespace App\Http\Middleware\Auth;

use Closure;
use Illuminate\Support\Facades\Gate;

class Manager
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
        if (Gate::allows('authManager')) {
            return $next($request);
        }
        else {
            return abort(404);
        }
    }
}
