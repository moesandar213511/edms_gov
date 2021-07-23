<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class SubDepartAdmin
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
        if(Auth::check()){
            if(Auth::user()->type == "sub_depart_admin"){
                return $next($request);
            }else{
                return redirect()->back();
            }
        }else{
            return redirect('/');
        }
    }
}
