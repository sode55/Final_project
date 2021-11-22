<?php

namespace App\Http\Controllers;

use Symfony\Component\Console\Input\Input;
use App\Http\Requests\VehicleRequest;
use APP\Http\Traits\Responses;
use Illuminate\Http\Request;
use App\Models\Vehicle;
use App\Models\User;
use Throwable;



class VehicleController extends Controller
{
//    use Responses;


#Add new vehicle.
    public function apiAddVehicle(VehicleRequest $request)

    {
        try {

            $request->validated();

            $vehicle = Vehicle::create([
                'name' => $request->name,
                'model' => $request->model,
                'accessories' => $request->accessories,
                'No_of_sits' => $request->No_of_sits,
                'plate_number' => $request->plate_number,
                'company_id' => $request->company_id,
            ]);


//            return  $this->getMessage($response->json(), $response->status());
//        }catch (Throwable $e) {
//            return $this->getError($response()->json(), $response()->status());

            return response()->json([
                "success" => true,
                'status' => 200,
                "message" => "وسیله نقلیه با موفقیت ثبت شد.",
                "data" => $vehicle
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'status' => $e->getCode(),
                'error' => $e->getMessage(),
                ]);
        }
    }

#edit a vehicle
    public function apiUpdateVehicle(VehicleRequest $request, $id)
    {
        try {

            $input = $request->all();
            $request->validated();

            $vehicle = Vehicle::find($id);

            $user = auth('api')->user();
            $userRole = $user->role->role_name;
            $userCompany =$user->company_id;

            $vehicleCompany = $vehicle->company_id;


            if($userRole == 'company_owner' && $userCompany !=$vehicleCompany)
            {
                return response()->json('unauthorized' , 403);
            }

            $vehicle->name = $input['name'];
            $vehicle->model = $input['model'];
            $vehicle->accessories = $input['accessories'];
            $vehicle->No_of_sits = $input['No_of_sits'];
            $vehicle->plate_number = $input['plate_number'];
            $vehicle->save();

//            return  $this->getMessage($response->json(), $response->status());
//        }catch (Throwable $e) {
//            return $this->getError($response()->json(), $response()->status());

            return response()->json([
                "success" => true,
                'status' => 200,
                "message" => "وسیله نقلیه با موفقیت ویرایش شد.",
                "data" => $vehicle
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'status' => $e->getCode(),
                'error' => $e->getMessage(),
                ]);
        }
    }

#arcive a vehicle
    public function apiAddToArchive($id)
    {
        try {

            $vehicle = Vehicle::find($id);

            $user = auth('api')->user();
            $userRole = $user->role->role_name;
            $userCompany =$user->company_id;

            $vehicleCompany = $vehicle->company_id;


            if($userRole == 'company_owner' && $userCompany !=$vehicleCompany) {
                return response()->json('unauthorized', 403);
            }

            $vehicle->delete();

//            return  $this->getMessage($response->json(), $response->status());
//        }catch (Throwable $e) {
//            return $this->getError($response()->json(), $response()->status());

            return response()->json([
                "success" => true,
                'status' => 200,
                "message" => "وسیله نقلیه با موفقیت آرشیو شد.",
                "data" => $vehicle
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'status' => $e->getCode(),
                'error' => $e->getMessage(),
                ]);
        }
    }

#show archived vehicle
    public function apiShowArchive()
    {
        try {

            $archivedVehicle = Vehicle::onlyTrashed()->get();

//            return  $this->getMessage($response->json(), $response->status());
//        }catch (Throwable $e) {
//            return $this->getError($response()->json(), $response()->status());

            return response()->json([
                "success" => true,
                'status' => 200,
                "message" => "لیست وسایل نقلیه آرشیو شده",
                "data" => $archivedVehicle
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'status' => $e->getCode(),
                'error' => $e->getMessage(),
                ]);
        }
    }
}
