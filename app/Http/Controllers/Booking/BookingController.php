<?php

namespace App\Http\Controllers\Booking;

use Throwable;
use function now;
use function auth;
use App\Models\Ride;
use function response;
use App\Jobs\BookingJob;
use App\Services\BookingService;
use App\Http\Controllers\Controller;
use App\Http\Requests\BookingRequest;
use App\Repositories\BookingRepository;

class BookingController extends Controller
{
     public $user;

    public function __construct(BookingRepository $bookingRepository, BookingService $bookingService)
    {
        $this->user = auth('api')->user();
        $this->bookingRepository = $bookingRepository;
        $this->bookingService = $bookingService;
    }

    public function Show($id)
    {
        try {
            $ride = Ride::find($id);
            $data = $this->bookingService->seatList(
            $this->bookingRepository->unavailableSeats($ride->vehicle_id),
            $this->bookingRepository->allSeats($ride->vehicle_id));
            $bookingId = $this->bookingRepository->bookingId($ride->vehicle_id);
            $allSeats = $this->bookingRepository->allSeats($ride->vehicle_id);
            if (empty($bookingId)) {
                return response()->json([
                    "success" => true,
                    "message" => "صندلی های انتخاب شده:",
                    "data" => $allSeats
                ]);
            }
//            return  $this->getMessage($response->json(), $response->status());
//        } catch (Throwable $e) {
//            return $this->getError($response()->json(), $response()->status());

            return response()->json([
                "success" => true,
                "message" => "لیست صندلی های رزرو شده:",
                "data" => $data
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
            $price = Ride::find($request->ride_id);
            $data = $this->bookingRepository->save($request,$price->peice, $this->user->id);
            BookingJob::dispatch($data, $this->user->id)->delay(now()->addMinutes(15));

//            return  $this->getMessage($response->json(), $response->status());
//        } catch (Throwable $e) {
//            return $this->getError($response()->json(), $response()->status());

            return response()->json([
                "success" => true,
                "message" => "رزرو با موفقیت انجام شد.",
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
