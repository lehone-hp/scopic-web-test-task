<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first()
            ]);
        }

        $user = User::where('username', $request->get('username'))->first();
        if ($user && Hash::check($request->get('password'), $user->password)) {
            return response()->json([
                'status' => 'success',
                'user' => [
                    'id' => $user->id,
                    'username' => $user->username
                ]
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'No user found for these credentials.'
        ]);
    }
}
