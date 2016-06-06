<?php

namespace App\Http\Middleware;

use Closure;
use Session;


class rootCheck
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
        if(Session::has('root')) {
            return $next($request);
        }else{
            return redirect('/');
        }

    }
}
