<?php

use App\Http\Controllers\PassportAuthController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:api')->post('register', 'RegisterController@apiRegister');

Route::middleware('auth:api')->post('login', 'LoginController@apiLogin');


//Route::middleware('auth:api')->post('login', 'PassportAuthController@apiLogin');
//Route::middleware('auth:api')->post('register', 'PassportAuthController@apiRegister');
