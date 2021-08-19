<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckApiPassword
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

        //condition check access  api key or password just use developer
        if ($request->api_check_password != env('API_KEY_PASSWORD', 'bV1wLK61eXIaks')) {
            return response()->json(['message' => 'Unauthenticated enter password']);
        }
        return $next($request);
    }
}
