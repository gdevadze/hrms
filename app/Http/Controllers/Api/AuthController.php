<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'pid' => 'required',
            'password' => 'required'
        ]);

        if (Auth::attempt($request->only('pid', 'password'))) {
            return response()->json(Auth::user(), 200);
        }

        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.']
        ]);
    }

    public function logout()
    {
        Auth::logout();
    }


    public function login_token(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
            'device_name' => ''
        ]);

        $user = User::where(['email' => $request->email])->orWhere('personal_num', $request->email)
            ->first();
        //return $user;
        if (! $user || ! Hash::check($request->password, $user->password)) {
            /*  throw ValidationException::withMessages([
                  'email' => ['The provided credentials are incorrect.'],
              ]);*/
            return response()->json(['email' => ['The provided credentials are incorrect.']], 404);
        }
        $device_name = 'mobile';
        return ['user' => $user, 'access_token' => $user->createToken($device_name)->plainTextToken];
        return $user->createToken($device_name, $user->getRoles())->plainTextToken;
    }


    public function logout_token(Request $request)
    {
        $user = $request->user();

        if ($user) {
            $user->tokens()->delete();
        }

        // return response()->json(['error' => $user ? 'User' : "NOne"]);
    }

    public function changePassword(Request $request)
    {
        $user = $request->user();
        // return $request->all();
        if (Hash::check($request->current_password, $user->password)) {
            if (!Hash::check($request->input('password'), $user->password)) {
                $user->update(['password' =>  Hash::make($request->input('password'))]);

                return jsonResponse(['status' => 0]);
            } else {
                return jsonResponse(['status' => 1]);
            }
        }

        return jsonResponse(['status' => 2,'user' => $user]);
    }
}
