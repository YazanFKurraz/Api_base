<?php

namespace App\Http\Middleware;

use App\Http\Traits\GerenalApi;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Throwable;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\JWTAuth;

class CheckAdminToken
{

    use GerenalApi;

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = null;
        try {

            $user = JWTAuth::parseToken()->authenticate();
        } catch (Exception $ex) {

            if ($ex instanceof TokenInvalidException) {
                return $this->errorMessage('INVALID_TOKEN');

            } else if ($ex instanceof TokenInvalidException) {
                return $this->errorMessage('EXPIRED_TOKEN');

            } else {
                return $this->errorMessage('TOKEN_NOTFOUND');

            }
        } catch (Throwable $ex) {

            if ($ex instanceof TokenInvalidException) {
                return $this->errorMessage('INVALID_TOKEN');

            } else if ($ex instanceof TokenInvalidException) {
                return $this->errorMessage('EXPIRED_TOKEN');

            } else {
                return $this->errorMessage('TOKEN_NOTFOUND');
            }
        }

        if (!$user)
            return $this->errorMessage('Unauthenticated');

        return $next($request);
    }
}
