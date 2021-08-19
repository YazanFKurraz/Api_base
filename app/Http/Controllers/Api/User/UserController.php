<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Traits\GerenalApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    use GerenalApi;

    public function profile(Request $request)
    {

        $user = Auth::user();
        if (!$user) {
            return $this->sendResponse(false, 'user mot found or unauth', '', 404);
        }
        return $this->sendResponse(true, 'show profile', $user, 200);
    }

    public function updateProfile(Request $request)
    {
        //not pass token in header and request "auth_token"
        $user = Auth::user();
        if (!$user) {
            return $this->sendResponse(false, 'user not found or unauth', '', 404);
        }

        if ($file = $request->file('file')) {

            //store file into document folder
            $file = $request->file->store('public/image/users');

            //store and edit your file into database
            $imageUser = $user->update([
                'image_path' => $file,
            ]);
        }
        //edit your new data into database

        $updateUser = $user->update([
            'name' => $request->name,
            'email' => $request->email
        ]);

        return $this->sendResponse(true, 'update successfully', compact('imageUser', 'updateUser'), 200);
    }


}
