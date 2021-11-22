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


Route::post('/login', 'PassportAuthController@apiLogin');
Route::post('/register', 'PassportAuthController@apiRegister');

Route::middleware(['auth:api', 'permission:superUser, admin, company_owner'])->group(function ()
{
    Route::post('vehicle/store', 'VehicleController@apiAddVehicle');
    Route::put('vehicle/edit/{id}', 'VehicleController@apiUpdateVehicle');
    Route::delete('bus/{id}', 'VehicleController@apiAddToArchive');
    Route::get('show/archive', 'VehicleController@apiShowArchive');

    Route::post('date/store', 'ReserveController@apiAddDateTime');
    Route::put('date/edit/{id}', 'ReserveController@apiUpdateDateTime');
});

Route::middleware('auth:api')
    ->post('/company/store', 'CompanyController@apiStoreCompany');
Route::get('/company/show', 'CompanyController@apiShowCompany');


Route::middleware(['auth:api', 'permission:superUser, admin, company_owner'])
    ->post('/comment/store', 'CommentController@apiAddComment');
Route::get('/comments/show', 'CommentController@apiShowComments');

Route::post('/bus/show', 'ReserveController@apiShowBus');
Route::post('/bus/show/orderBY', 'ReserveController@apiShowBusOrderBy');
