<?php

namespace App\Http\Controllers;

use App\Http\Requests\RideStoreRequest;
use App\Repositories\RideRepository;
use App\Http\Requests\RideRequest;
//use APP\Http\Traits\Responses;
use App\Models\Vehicle;
use App\Models\Ride;
use Throwable;

class RideController extends Controller
{
//    use Responses;
    public $user;

public function __construct(RideRepository $rideRepository)
{
    $this->user = auth('api')->user();
    $this->rideRepository = $rideRepository;
}
//save ride info
    public function store(RideRequest $request)
    {
        try {
            $vehicleCapacity = Vehicle::find($request->vehicle_id);
           $data = $this->rideRepository->save($request,$vehicleCapacity->capacity);

//            return  $this->getMessage($response->json(), $response->status());
//        }catch (Throwable $e) {
//            return $this->getError($response()->json(), $response()->status());

            return response()->json([
                "success" => true,
                'status' => 200,
                "message" => " ثبت با موفقیت انجام شد.",
                "data" => $data
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'status' => $e->getCode(),
                'error' => $e->getMessage(),
                ]);
        }
    }
//edit ride info
    public function update(RideRequest $request, $id)
    {
        try {
            $userRole = $this->user->role->role_name;
            $userCompany = $this->user->company_id;
            $ride = Ride::find($id);
            $vehicleCompany = $ride->vehicle->company_id;
            if($userRole == 'company_owner' && $userCompany != $vehicleCompany)
            {
                return response()->json('unauthorized' , 403);
            }
            $data = $this->rideRepository->edit($request, $id);

//            return  $this->getMessage($response->json(), $response->status());
//        }catch (Throwable $e) {
//            return $this->getError($response()->json(), $response()->status());

            return response()->json([
                "success" => true,
                'status' => 200,
                "message" => "ویرایش با موفقیت انجام شد.",
                "data" => $data
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'status' => $e->getCode(),
                'error' => $e->getMessage(),
                ]);
        }
    }
//show list of bus by time of departure in ascending order

    public function show(RideStoreRequest $request)
    {
        try {
            $vehicles =  $this->rideRepository->vehicleList($request);

//            return  $this->getMessage($response->json(), $response->status());
//        }catch (Throwable $e) {
//            return $this->getError($response()->json(), $response()->status());

            if(empty($vehicles))
            {
                return response()->json([
                    "success" => true,
                    'status' => 200,
                    "message" => "موردی یافت نشد",
                    "data" => $vehicles
                ]);
            }

            return response()->json([
                "success" => true,
                'status' => 200,
                "message" => "لیست وسایل نقلیه در تاریخ مورد نظر:",
                "data" => $vehicles
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'status' => $e->getCode(),
                'error' => $e->getMessage(),
            ]);
        }
    }
#show bus list by order of time of departure, model, No_of_sits, price

    public function ShowOrderBy( RideStoreRequest $request)
    {
        try {

           $data =  $this->rideRepository->list($request);


            if(empty($data))
            {
                return response()->json([
                    "success" => true,
                    'status' => 200,
                    "message" => "موردی یافت نشد",
                ]);
            }

            return response()->json([
                "success" => true,
                'status' => 200,
                "message" => "لیست وسایل نقلیه در تاریخ مورد نظر:",
                "data" => $data
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'status' => $e->getCode(),
                'error' => $e->getMessage(),
            ]);
        }
    }
}
