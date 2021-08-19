<?php

namespace App\Http\Middleware;

use App\Http\Traits\GerenalApi;
use Closure;
use Faker\Provider\Base;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class AssignGuard extends BaseMiddleware
{

    use GerenalApi;

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed

     */
    public function handle(Request $request, Closure $next, $guard = null)
    {

            if($guard != null){
                auth()->shouldUse($guard); //shoud you user guard / table
                $token = $request->header('auth_token');
                $request->headers->set('auth_token', (string) $token, true);
                $request->headers->set('Authorization', 'Bearer '.$token, true);
                try {
                    $user = JWTAuth::parseToken()->authenticate();//check authenticated user
                } catch (TokenExpiredException $e) {
                    return  $this -> sendResponse(false,'Unauthenticated user','',401);
                } catch (JWTException $e) {
                    return  $this -> sendResponse(false,'token inValid','',401);
                }

            }
            return $next($request);
        }
    }
