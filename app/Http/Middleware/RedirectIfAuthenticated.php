<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Session;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
		$guard = $request->session()->get('credentials', 'guest');
        /*if (Auth::guard($guard)->check()) {
            return redirect('/');
        }*/
		
		if ($guard == 'guest')
        {
            /*if ($request->ajax())
            {
                return response('Unauthorized.', 401);
            }
            else
            {*/
                return redirect('/');
            //}
        }

        return $next($request);
    }
}
