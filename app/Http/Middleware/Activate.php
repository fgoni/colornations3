<?php

namespace App\Http\Middleware;

use Closure;

class Activate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!$request->user()->activated) {
            if ($request->ajax()) {
                return response('Not Activated.', 401);
            } else {
                return redirect('dashboard/settings')->withErrors('You need to activate your account before proceeding');
            }
        }

        return $next($request);
    }
}
