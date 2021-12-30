<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterStoreRequest;
use App\Http\Requests\LoginStoreRequest;
use App\Repositories\UserRepository;
//use APP\Http\Traits\Responses;
use Throwable;


class PassportAuthController extends Controller
{
//    use Responses;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function register(RegisterStoreRequest $request)
    {
        try {

            $data = $this->userRepository->save($request);
            $token = $data->createToken('LaravelAuthApp')->accessToken;

//            return  $this->getMessage($response->json(), $response->status());
//        }catch (Throwable $e) {
//            return $this->getError($response()->json(), $response()->status());

            return response()->json([
                "success" => true,
                'status' => 200,
                "message" => "ثبت نام با موفقیت انجام شد.",
                "data" => $data,
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
        try {


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
