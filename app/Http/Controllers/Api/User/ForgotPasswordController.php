<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ForgotPaaswordRequest;
use App\Http\Traits\GerenalApi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    use GerenalApi;

    public function forgot(ForgotPaaswordRequest $request)
    {

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return $this->sendResponse(false, 'email user not found', '', 400);
        }

        $email = $user->email;
        Password::sendResetLink(compact('email'));

        return $this->sendResponse(true, 'password reset email sent', $email, 200);
    }
}
