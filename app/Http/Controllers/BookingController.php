<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use App\Repositories\BookingRepository;
use App\Http\Requests\BookingRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Jobs\BookingJob;
use App\Models\Vehicle;
use App\Models\Booking;
use App\Models\Ride;
use Throwable;


class BookingController extends Controller
{
    public function __construct(BookingRepository $bookingRepository)
    {
        $this->bookingRepository = $bookingRepository;
    }

    public function ShowSeats($id)
    {
        try {

            $ride = Ride::find($id);
            $vehicleId = $ride->vehicle_id;


            $showSeats = $this->bookingRepository->availableSeats($vehicleId);
            $bookingId = $this->bookingRepository->bookingId($vehicleId);
            $allSeats = $this->bookingRepository->allSeats($vehicleId);

            if (empty($bookingId)) {
                return response()->json([
                    "success" => true,
                    "message" => "صندلی های انتخاب شده:",
                    "data" => $allSeats
                ]);
            }

//            return  $this->getMessage($response->json(), $response->status());
//        }catch (Throwable $e) {
//            return $this->getError($response()->json(), $response()->status());

            return response()->json([
                "success" => true,
                "message" => "لیست صندلی های رزرو شده:",
                "data" => $showSeats
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'status' => $e->getCode(),
                'error' => $e->getMessage(),
            ]);
        }
    }


    public function Store(BookingRequest $request)
    {
        try {

            $user = auth('api')->user();

            $input = [];
            for ($i = 0; $i < count($request->seat); $i++) {
                $input[] = [
                    'passenger_name' => $request->passenger_name,
                    'gender' => $request->gender[$i],
                    'seat' => $request->seat[$i],
                    'ride_id' => $request->ride_id,
                    'user_id' => $user->id,
                ];

                $booking = Booking::create($input[$i]);
            }


                BookingJob::dispatch($booking, $user->id)->delay(now()->addMinutes(15));


//            return  $this->getMessage($response->json(), $response->status());
//        }catch (Throwable $e) {
//            return $this->getError($response()->json(), $response()->status());

            return response()->json([
            "success" => true,
              "message" => "رزرو با موفقیت انجام شد.",
             "data" => $input
             ]);
            }catch(Throwable $e) {
             return response()->json([
              'status' => $e->getCode(),
              'error' => $e->getMessage(),
              ]);
        }
    }


    public function ShowReceipt()
    {
        try {
            $user = auth('api')->user();
            $userId = $user->id;

            $receipt = $this->bookingRepository->receipt($userId);


//            return  $this->getMessage($response->json(), $response->status());
//        }catch (Throwable $e) {
//            return $this->getError($response()->json(), $response()->status());

            return response()->json([
                "success" => true,
                "message" => "نمایش رسید:",
                "data" => $receipt
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'status' => $e->getCode(),
                'error' => $e->getMessage(),
            ]);
        }
    }
}
