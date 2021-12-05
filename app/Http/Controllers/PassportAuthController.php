<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterStoreRequest;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\LoginStoreRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Throwable;


class PassportAuthController extends Controller
{
    public function register(RegisterStoreRequest $request)
    {
        try{

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'mobile' => $request->mobile,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        $token = $user->createToken('LaravelAuthApp')->accessToken;


//            return  $this->getMessage($response->json(), $response->status());
//        }catch (Throwable $e) {
//            return $this->getError($response()->json(), $response()->status());

            return response()->json([
                "success" => true,
                'status' => 200,
                "message" => "ثبت نام با موفقیت انجام شد.",
                "data" => $user,
                'token' => $token,
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'status' => $e->getCode(),
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Login
     */
    public function login(LoginStoreRequest $request)
    {
        try{


        $user = [
            'username' => $request->username,
            'password' => $request->password
        ];

        if (auth()->attempt($user)) {
            $token = auth()->user()->createToken('LaravelAuthApp')->accessToken;

            //            return  $this->getMessage($response->json(), $response->status());
//        }catch (Throwable $e) {
//            return $this->getError($response()->json(), $response()->status());

            return response()->json([
                "success" => true,
                'status' => 200,
                "message" => "ثبت نام با موفقیت انجام شد.",
                "data" => $user,
                'token' => $token,
            ]);
        }
        } catch (Throwable $e) {
                return response()->json([
                    'status' => $e->getCode(),
                    'error' => $e->getMessage(),
                ]);
            }
    }

}
