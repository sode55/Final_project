<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginStoreRequest;
use Illuminate\Support\Facades\Http;
use App\Http\Traits\Responses;
//use Illuminate\Http\Request;
use Laravel\Passport\Client;
use Throwable;


class LoginController extends Controller
{
    use Responses;


    public function login(LoginStoreRequest $request)
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
        return  $this->getMessage($response->json(), $response->status());
        }catch (Throwable $e) {
            return $this->getError($response()->json(), $response()->status());
        }

    }


}
