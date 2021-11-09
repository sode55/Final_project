<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterStoreRequest;
use Illuminate\Support\Facades\Http;
//use APP\Http\Traits\Responses;
use Illuminate\Http\Request;
use Laravel\Passport\Client;
use App\Models\User;
use Throwable;

class RegisterController extends Controller
{
    public function apiRegister(RegisterStoreRequest $request)
    {

        try {

            $validator = $request->validated();
            $data = $request->all();

            if ($validator->fails()) {
                return response()->json($validator->errors()->first(), 422);
            }
            $data['password'] = bcrypt($request->password);
            $user = User::create($data);


            $client = Client::where('password_client', 1)->firstOrFail();

            $response = Http::asForn()->post(env('APP_URL') . '/oauth/token', [
                'grant_type' => 'password',
                'client_id' => $client->id,
                'client_secret' => $client->secret,
                'username' => $request->username,
                'password' => $request->password,
                'scope' => ''
            ]);
            return  response()->json($response->message()->first(), 200);
        } catch (Throwable $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);

        }
    }

}
