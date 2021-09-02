<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use Illuminate\Support\Facades\Auth;

class ApiLanguage
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
        $lang=User::where('id',Auth::user()->id)->first()->language;
        $languages = language();
        if (in_array($lang, array_keys($languages))) {
            app()->setLocale($lang);
        } else {
            app()->setLocale('en');
        }
        return $next($request);
    }
}
