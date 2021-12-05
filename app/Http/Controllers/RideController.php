<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use App\Http\Requests\RideStoreRequest;
use App\Repositories\RideRepository;
use App\Http\Requests\RideRequest;
use APP\Http\Traits\Responses;
use Illuminate\Http\Request;
use App\Models\Vehicle;
use App\Models\Ride;
use Carbon\Carbon;

use Illuminate\Support\Facades\DB;

use Throwable;

class RideController extends Controller
{
//    use Responses;

public function __construct(RideRepository $rideRepository)
{
    $this->rideRepository = $rideRepository;
}

    public function store(RideRequest $request)

    {

        try {

            $vehicleCapacity = Vehicle::find($request->vehicle_id);

            $ride = Ride::create([
                'origin' => $request->origin,
                'destination' => $request->destination,
                'departure_date' => $request->departure_date,
                'departure_time' => $request->departure_time,
                'price' => $request->price,
                'vehicle_id' => $request->vehicle_id,
                'remaining_capacity' => $vehicleCapacity->capacity,
            ]);


//            return  $this->getMessage($response->json(), $response->status());
//        }catch (Throwable $e) {
//            return $this->getError($response()->json(), $response()->status());

            return response()->json([
                "success" => true,
                'status' => 200,
                "message" => " ثبت با موفقیت انجام شد.",
                "data" => $ride
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'status' => $e->getCode(),
                'error' => $e->getMessage(),
                ]);
        }
    }

    public function update(RideRequest $request, $id)
    {
        try {

            $input = $request->all();

            $ride = Ride::find($id);

            $user = auth('api')->user();
            $userRole = $user->role->role_name;
            $userCompany = $user->company_id;

            $vehicleCompany = $ride->vehicle->company_id;

            if($userRole == 'company_owner' && $userCompany !=$vehicleCompany)
            {
                return response()->json('unauthorized' , 403);
            }

            $ride->origin = $input['origin'];
            $ride->destination = $input['destination'];
            $ride->departure_date = $input['departure_date'];
            $ride->departure_time = $input['departure_time'];
            $ride->price = $input['price'];
            $ride->save();

//            return  $this->getMessage($response->json(), $response->status());
//        }catch (Throwable $e) {
//            return $this->getError($response()->json(), $response()->status());

            return response()->json([
                "success" => true,
                'status' => 200,
                "message" => "ویرایش با موفقیت انجام شد.",
                "data" => $ride
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'status' => $e->getCode(),
                'error' => $e->getMessage(),
                ]);
        }
    }
#show list of bus by time of departure in ascending order

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
