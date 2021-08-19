<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\UserLoginRequest;
use App\Http\Traits\GerenalApi;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Validator;
use function Symfony\Component\Translation\t;

class UserAuthController extends Controller
{

    use GerenalApi;

    public function __construct()
    {

    }

    public function register(Request $request){

        $user =  User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
        ]);

        $user->save();




    }

    public function login(UserLoginRequest $request)
    {
        //login
        $credentials = $request->only(['email', 'password']);

        $token = $this->guard()->attempt($credentials);

        if (!$token)
            return $this->sendResponse(false, 'Error email and password', '', 400);

        $user = $this->guard()->user();

        //return token
        $user->api_token = $token;

        return $this->sendResponse(true, 'login success', $user, 200);

    }

    public function guard()
    {
        return Auth::guard('user_api');
    }

    public function me()
    {
        $user = $this->guard()->user();

        return $this->sendResponse(true, 'me', $user, 200);
    }

    public function logout(Request $request)
    {

        $token = $request->header('auth_token');

        if ($token) {

            try {
                JWTAuth::setToken($token)->invalidate(); // logout

            } catch (TokenInvalidException $ex) {

                return $this->sendResponse(false, 'error', '', 404);
            }

            return $this->sendResponse(true, 'logout successfully', '', 200);

        } else {

            return $this->sendResponse(false, 'error', '', 404);

        }

    }

    /**
     * Get the token array structure.
     *
     * @param string $token
     *
     * @return JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $this->guard()->factory()->getTTL() * 60
        ]);
    }

}
