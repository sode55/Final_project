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

Route::middleware(['auth:api', 'permission:superUser, admin, companyOwner'])->group(function ()
{
    Route::post('vehicle', 'VehicleController@apiAddVehicle');
    Route::put('vehicle/edit/{id}', 'VehicleController@apiUpdateVehicle');
    Route::delete('archive/{id}', 'VehicleController@apiAddToArchive');
    Route::get('show/archive', 'VehicleController@apiShowArchive');
});

Route::middleware('auth:api')->post('/company', 'CompanyController@apiStoreCompany');


