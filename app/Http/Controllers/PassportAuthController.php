<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterStoreRequest;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\LoginStoreRequest;
use Illuminate\Http\Request;
use App\Models\User;


class PassportAuthController extends Controller
{
    public function apiRegister(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            "username" => 'required|unique:users,username|min:3',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/',
            'confirmPassword' => 'required|same:password',
        ]);


        if ($validator->fails()) {
            return response()->json($validator->errors()->first(), 422);
        }

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        $token = $user->createToken('LaravelAuthApp')->accessToken;

        return response()->json([
            "success" => true,
            'status' => 200,
            "message" => "ثبت نام با موفقیت انجام شد.",
            "data" => $user,
            'token' => $token,
            ]);
    }

    /**
     * Login
     */
    public function apiLogin(Request $request)
    {

        $request->validate([
            'username' => 'required|exists:users,username',
            'password' => 'required'
        ]);

        $user = [
            'username' => $request->username,
            'password' => $request->password
        ];

        if (auth()->attempt($user)) {
            $token = auth()->user()->createToken('LaravelAuthApp')->accessToken;
            return response()->json([
                "success" => true,
                'status' => 200,
                "message" => "ورود با موفقیت انجام شد.",
                "data" => $user,
                'token' => $token,
            ]);
        } else {
            return response()->json(['error' => 'Unauthorised'], 401);
        }
    }
}
