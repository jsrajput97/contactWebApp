<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if(Auth::guard($guard)->guest()){
            if($request->ajax()){
                return response('Unauthorized', 401);
            }
            else{
                return redirect()->route('userhome')->with(['message' => 'Please login first']);
            }
        }
        return $next($request);
    }
}
