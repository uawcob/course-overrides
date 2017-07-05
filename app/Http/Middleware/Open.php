<?php

namespace App\Http\Middleware;

use Closure;
use App\Schedule;

class Open
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
        if (Schedule::isOpen() || $request->user()->isAdmin()) {
            return $next($request);
        }

        return redirect('/');
    }
}
