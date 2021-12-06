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

//Route::post('register', 'RegisterController@apiRegister');
//Route::post('login', 'LoginController@apiLogin');


Route::post('/login', 'PassportAuthController@login');
Route::post('/register', 'PassportAuthController@register');

Route::middleware(['auth:api', 'permission:superUser, admin, company_owner'])->group(function ()
{
    Route::post('vehicles', 'VehicleController@store');
    Route::put('vehicles/{id}', 'VehicleController@update');
    Route::delete('vehicles/{id}', 'VehicleController@archive');
    Route::get('vehicles', 'VehicleController@ShowArchive');

    Route::post('rides', 'RideController@store');
    Route::put('rides/{id}', 'RideController@update');
});

Route::middleware('auth:api')
    ->post('/companies', 'CompanyController@store');
Route::get('/companies', 'CompanyController@show');


Route::middleware(['auth:api', 'permission:superUser, admin, company_owner'])
    ->post('/comments', 'CommentController@store');
Route::get('/comments', 'CommentController@show');

Route::post('/bus', 'RideController@Show');
Route::post('/bus/orderBy', 'RideController@ShowOrderBy');

Route::get('/seats/{id}', 'BookingController@ShowSeats');
Route::middleware('auth:api')->post('/bookings', 'BookingController@store');
Route::middleware('auth:api')->get('/receipts', 'BookingController@ShowReceipt');

