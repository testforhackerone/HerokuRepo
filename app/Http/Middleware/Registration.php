<?php

namespace App\Http\Middleware;

use Closure;

class Registration
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
        $adm_setting = allsetting();
        if(isset($adm_setting['user_registration']) && $adm_setting['user_registration'] == 2 ) {
            return redirect()->route('login');
        } else {
            return $next($request);
        }    }
}
