<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckLanguage
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        //defualt language arabic
        app()->setLocale('ar');

        //condition language en or ar
        if (isset($request->language) && $request->language == 'en') {
            app()->setLocale('en');
        }
        return $next($request);
    }
}
