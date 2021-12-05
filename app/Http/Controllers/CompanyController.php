<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyRequest;
//use APP\Http\Traits\Responses;
use Illuminate\Http\Request;
use App\Models\Company;
use Throwable;

class CompanyController extends Controller
{
//    use Responses;
#save data into database
    public function store(CompanyRequest $request)
    {
        try {

            $user = auth('api')->user();
            $userId = $user->id;

            $company = Company::create([
                'name' => $request->name,
                'phone_number' => $request->phone_number,
                'email' => $request->email,
                'address' => $request->address,
                'user_id' => $userId,
              ]);


//            return  $this->getMessage($response->json(), $response->status());
//        }catch (Throwable $e) {
//            return $this->getError($response()->json(), $response()->status());

            return response()->json([
                "success" => true,
                "message" => "شرکت با موفقیت ثبت شد.",
                "data" => $company
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'status' => $e->getCode(),
                'error' => $e->getMessage(),
                ]);
        }
    }
#show some companies
    public function show()
    {
        try {
            $company = Company::inRandomOrder()->limit(5)->get(['name', 'phone_number', 'email', 'address']);

//            return  $this->getMessage($response->json(), $response->status());
//        }catch (Throwable $e) {
//            return $this->getError($response()->json(), $response()->status());

            return response()->json([
                "success" => true,
                "message" => "لیست شرکت های طرف قرارداد.",
                "data" => $company
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'status' => $e->getCode(),
                'error' => $e->getMessage(),            ]);
        }
    }
}
