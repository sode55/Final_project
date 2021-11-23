<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReserveRequest;
use App\Repositories\ReserveRepository;
use APP\Http\Traits\Responses;
use Illuminate\Http\Request;
use App\Models\Reserve;
use Carbon\Carbon;

use Illuminate\Support\Facades\DB;
use Throwable;

class ReserveController extends Controller
{
//    use Responses;

public function __construct(ReserveRepository $reserve)
{
    $this->reserve = $reserve;
}

    public function apiAddDateTime(ReserveRequest $request)

    {

        try {

            $request->validated();

            $reserve = Reserve::create([
                'origin' => $request->origin,
                'destination' => $request->destination,
                'departure_date' => $request->departure_date,
                'departure_time' => $request->departure_time,
                'price' => $request->price,
                'vehicle_id' => $request->vehicle_id,
            ]);


//            return  $this->getMessage($response->json(), $response->status());
//        }catch (Throwable $e) {
//            return $this->getError($response()->json(), $response()->status());

            return response()->json([
                "success" => true,
                'status' => 200,
                "message" => " ثبت با موفقیت انجام شد.",
                "data" => $reserve
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'status' => $e->getCode(),
                'error' => $e->getMessage(),            ]);
        }
    }

    public function apiUpdateDateTime(ReserveRequest $request, $id)
    {
        try {

            $input = $request->all();
            $request->validated();

            $reserve = Reserve::find($id);

            $user = auth('api')->user();
            $userRole = $user->role->role_name;
            $userCompany = $user->company_id;

            $vehicleCompany = $reserve->vehicle->company_id;

            if($userRole == 'company_owner' && $userCompany !=$vehicleCompany)
            {
                return response()->json('unauthorized' , 403);
            }

            $reserve->origin = $input['origin'];
            $reserve->destination = $input['destination'];
            $reserve->departure_date = $input['departure_date'];
            $reserve->departure_time = $input['departure_time'];
            $reserve->price = $input['price'];
            $reserve->save();

//            return  $this->getMessage($response->json(), $response->status());
//        }catch (Throwable $e) {
//            return $this->getError($response()->json(), $response()->status());

            return response()->json([
                "success" => true,
                'status' => 200,
                "message" => "ویرایش با موفقیت انجام شد.",
                "data" => $reserve
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'status' => $e->getCode(),
                'error' => $e->getMessage(),
                ]);
        }
    }
#show list of bus by time of departure in ascending order
    public function apiShowBus(Request $request)
    {
        try {

          $reserve =  Reserve::with(['vehicle' => function ($query){
                $query->select('id', 'name', 'model');
            }])
              ->select('origin', 'destination', 'departure_date','departure_time',
              'No_of_sits', 'price', 'vehicle_id')
              ->whereDate('departure_date', $request->preferred_date )
              ->where('origin', $request->origin)
              ->where('destination', $request->destination)
              ->OrderBy('departure_time', 'asc')->get();


//            return  $this->getMessage($response->json(), $response->status());
//        }catch (Throwable $e) {
//            return $this->getError($response()->json(), $response()->status());

            if(empty($reserve))
            {
                return response()->json([
                    "success" => true,
                    'status' => 200,
                    "message" => "موردی یافت نشد",
                    "data" => $reserve
                ]);
            }

            return response()->json([
                "success" => true,
                'status' => 200,
                "message" => "لیست وسایل نقلیه در تاریخ مورد نظر:",
                "data" => $reserve
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'status' => $e->getCode(),
                'error' => $e->getMessage(),
            ]);
        }
    }
#show bus list by order of time of departure, model, No_of_sits, price
    public function apiShowBusOrderBy( Request $request)
    {
        try {

//            $orderBy = $request->input('orderBy');
//
//
//            $data = DB::table('reserves')
//                ->join('vehicles', 'reserves.vehicle_id', '=', 'vehicles.id')
//                ->select(
//                    'reserves.origin',
//                    'reserves.destination',
//                    'reserves.departure_date',
//                    'reserves.departure_time',
//                    'reserves.price',
//                    'reserves.no_of_sits',
//                    'vehicles.model',
//                    'vehicles.name',
//                )
//                ->whereDate('departure_date', $request->preferred_date )
//                ->where('origin', $request->origin)
//                ->where('destination', $request->destination)
//                ->when($orderBy, function ($query) use ($orderBy) {
//                    return $query->orderBy($orderBy, 'asc');
//                })->get();



           $data =  $this->reserve->list($request);



            if(empty($data))
            {
                return response()->json([
                    "success" => true,
                    'status' => 200,
                    "message" => "موردی یافت نشد",
                    "data" => $data
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
