<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyRequest;
//use APP\Http\Traits\Responses;
use App\Repositories\CompanyRepository;
use Throwable;

class CompanyController extends Controller
{
//    use Responses;
    public $user;

    public function __construct(CompanyRepository $companyRepository)
    {
        $this->user = auth('api')->user();
        $this->companyRepository = $companyRepository;
    }

//save data into database
    public function store(CompanyRequest $request)
    {
        try {
           $data = $this->companyRepository->save($request, $this->user->id);

//            return  $this->getMessage($response->json(), $response->status());
//        }catch (Throwable $e) {
//            return $this->getError($response()->json(), $response()->status());

            return response()->json([
                "success" => true,
                "message" => "شرکت با موفقیت ثبت شد.",
                "data" => $data
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'status' => $e->getCode(),
                'error' => $e->getMessage(),
            ]);
        }
    }

//show some companies
    public function show()
    {
        try {
            $data = $this->companyRepository->list();
//            return  $this->getMessage($response->json(), $response->status());
//        }catch (Throwable $e) {
//            return $this->getError($response()->json(), $response()->status());

            return response()->json([
                "success" => true,
                "message" => "لیست شرکت های طرف قرارداد.",
                "data" => $data
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'status' => $e->getCode(),
                'error' => $e->getMessage(),]);
        }
    }
}
