<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class MustHaveToken
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
//        $user = Auth::user()->remember;
//        $user = $request->user();
        if(Auth::user() && Auth::user()->slack_token != '') {
            return $next($request);
        }
        else{
            return redirect('/auth/slack');
        }
    }
}
