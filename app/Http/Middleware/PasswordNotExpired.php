<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use Illuminate\Support\Facades\Auth;

class PasswordNotExpired
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
        if(Auth::user()->locked_status == 2) {
            Session::flash('danger', 'Your password has expired. Change password.');
            return redirect()->route('admincp.password.change');
        }
        if( Auth::user()->locked_status != 0 ) {
            Auth::logout();
            Session::flash('danger', 'You have been logged out for security purposes.');
            return redirect()->route('admincp.login');
        }

        return $next($request);
    }
}
