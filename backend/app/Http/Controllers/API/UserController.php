<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserSettingResource;
use App\User;
use App\UserSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function fetchSettings(Request $request, $user_id)
    {
        $user = User::find($user_id);

        if (!$user) {
            return response()->json('User Not Found', 404);
        }

        return new UserSettingResource($user->setting);
    }

    public function updateSettings(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'max_auto_bid' => 'required|numeric|gte:0',
            'auto_bid_reserve' => 'required|numeric|between:0,100'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first()
            ]);
        }

        UserSetting::where('user_id', $request->get('user_id'))
            ->update([
                'max_auto_bid' => $request->get('max_auto_bid'),
                'auto_bid_reserve' => $request->get('auto_bid_reserve')
            ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Setting updated successfully'
        ]);
    }
}
