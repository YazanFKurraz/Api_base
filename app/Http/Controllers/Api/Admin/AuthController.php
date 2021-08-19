<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Traits\GerenalApi;
use App\Models\Admin;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Validator;
use function Symfony\Component\Translation\t;

class AuthController extends Controller
{

    use GerenalApi;

    public function __construct()
    {

    }

    public function login(LoginRequest $request)
    {
        //validation

//        $rules = [
//
//            'email' => 'required|exists:admins,email',
//            'password' => 'required'
//
//        ];
//
//        $validate = Validator::make($request->all(), $rules);
//
//        if ($validate->fails()) {
//
//            $code = $this->returnCodeAccordingToInput($validate);
//            return $this->returnValidationError($code, $validate);
//
//        }

        //login
        $credentials = $request->only(['email', 'password']);

        $token = $this->guard()->attempt($credentials);
//        if ($token = Auth::guard('admin_api')->attempt($credentials)) {
//            return $this->respondWithToken($token);
//        }

        if (!$token)
            return $this->sendResponse(false, 'Error email and password', '', 400);

        $admin = $this->guard()->user();

        //return token
        $admin->api_token = $token;

        return $this->sendResponse(true, 'login success', $admin, 200);

    }

    public function guard()
    {
        return Auth::guard('admin_api');
    }

    public function me(Request $request)
    {
        $admin = Auth::guard('admin_api')->user();

        if(!$admin){
            return $this->sendResponse(false, 'not found admin', '', 404);

        }

        return $this->sendResponse(true, 'me', $admin, 200);
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
