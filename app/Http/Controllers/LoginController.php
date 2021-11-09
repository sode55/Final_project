<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginStoreRequest;
use Illuminate\Support\Facades\Http;
//use APP\Http\Traits\Responses;
use Illuminate\Http\Request;
use Laravel\Passport\Client;
use Throwable;


class LoginController extends Controller
{
//    use Responses;


    public function apiLogin(LoginStoreRequest $request)
    {
        try {

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
        }catch (Throwable $e) {
            return $this->getError($response()->json(), $response()->status('422'));
        }

    }


}
