<?php

namespace App\Http\Controllers;

use App\Repositories\VehicleRepository;
use App\Http\Requests\VehicleRequest;
//use App\Http\Traits\Responses;
use App\Models\Vehicle;
use Throwable;



class VehicleController extends Controller
{
//    use Responses;
    public $user;

    public function __construct(VehicleRepository $vehicleRepository)
    {
        $this->user = auth('api')->user();
        $this->vehicleRepository = $vehicleRepository;
    }

//Add new vehicle.
    public function store(VehicleRequest $request)
    {
        try {
           $data = $this->vehicleRepository->save($request);

//            return  $this->getMessage($response->json(), $response->status());
//        }catch (Throwable $e) {
//            return $this->getError($response()->json(), $response()->status());

            return response()->json([
                "success" => true,
                'status' => 200,
                "message" => "وسیله نقلیه با موفقیت ثبت شد.",
                "data" => $data
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'status' => $e->getCode(),
                'error' => $e->getMessage(),
                ]);
        }
    }

//edit a vehicle
    public function update(VehicleRequest $request, $id)
    {
        try {
            $userRole = $this->user->role->role_name;
            $userCompany = $this->user->company_id;
            $vehicle = Vehicle::find($id);
            $vehicleCompany = $vehicle->company_id;
            if($userRole == 'company_owner' && $userCompany !=$vehicleCompany)
            {
                return response()->json('unauthorized' , 403);
            }
            $data = $this->vehicleRepository->edit($request, $id);

//            return  $this->getMessage($response->json(), $response->status());
//        }catch (Throwable $e) {
//            return $this->getError($response()->json(), $response()->status());

            return response()->json([
                "success" => true,
                'status' => 200,
                "message" => "وسیله نقلیه با موفقیت ویرایش شد.",
                "data" => $data
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'status' => $e->getCode(),
                'error' => $e->getMessage(),
                ]);
        }
    }

//arcive a vehicle
    public function archive($id)
    {
        try {
            $userRole = $this->user->role->role_name;
            $userCompany =$this->user->company_id;
            $vehicle = Vehicle::find($id);
            $vehicleCompany = $vehicle->company_id;

            if($userRole == 'company_owner' && $userCompany !=$vehicleCompany) {
                return response()->json('unauthorized', 403);
            }
            $data = $this->vehicleRepository->destroy($id);

//            return  $this->getMessage($response->json(), $response->status());
//        }catch (Throwable $e) {
//            return $this->getError($response()->json(), $response()->status());

            return response()->json([
                "success" => true,
                'status' => 200,
                "message" => "وسیله نقلیه با موفقیت آرشیو شد.",
                "data" => $data
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'status' => $e->getCode(),
                'error' => $e->getMessage(),
                ]);
        }
    }

#show archived vehicle
    public function Show()
    {
        try {
            $data = $this->vehicleRepository->list();

//            return  $this->getMessage($response->json(), $response->status());
//        }catch (Throwable $e) {
//            return $this->getError($response()->json(), $response()->status());

            return response()->json([
                "success" => true,
                'status' => 200,
                "message" => "لیست وسایل نقلیه آرشیو شده",
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
