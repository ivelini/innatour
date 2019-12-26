<?php

namespace App\Http\Middleware\Auth;

use Closure;
use Illuminate\Support\Facades\Gate;

class Admin
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
        if (Gate::allows('authAdmin')) {
            return $next($request);
        }
        else {
            return abort(404);
        }
    }
}
