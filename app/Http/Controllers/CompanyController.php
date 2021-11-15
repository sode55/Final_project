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

    public function apiStoreCompany(CompanyRequest $request)
    {
        try {
            $request->validated();


            $company = Company::create([
                'company_name' => $request->company_name,
                'phone_number' => $request->phone_number,
                'address' => $request->address,
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
                'error' => $e->getMessage()
            ]);
        }
    }
}
