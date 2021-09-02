<?php

namespace App\Http\Middleware;

use App\Exceptions\ApiException;
use Closure;
use Illuminate\Support\Facades\Auth;

class User
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
        if (isset(Auth::user()->id) && Auth::user()->role == USER_ROLE_USER && Auth::user()->active_status == STATUS_SUCCESS) {
            return $next($request);
        } else {
            throw new ApiException(__('Unauthorised'),401);
        }
    }
}
