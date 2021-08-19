<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResoures;
use App\Http\Traits\GerenalApi;
use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class RegisterController extends Controller
{

    use GerenalApi;
    public function register(Request $request){

       $user =  User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            ]);

       $user->save();
        $token = JWTAuth::fromUser($user); // create token user in databse

        $user->injectToken($token); // inject token in user with return data

        $user = new UserResoures($user); // order data with return

        return $this->sendResponse(true,'register successfully', $user, 200);


    }
}
