<?php

namespace App\Http\Controllers\Booking;

use Throwable;
use App\Http\Controllers\Controller;
use App\Repositories\BookingRepository;

class TicketController extends Controller
{
    public $user;

    public function __construct(BookingRepository $bookingRepository)
    {
        $this->user = auth('api')->user();
        $this->bookingRepository = $bookingRepository;
    }

    public function Show()
    {
        try {
            $data = $this->bookingRepository->receipt($this->user->id);

//          return  $this->getMessage($response->json(), $response->status());
//        }catch (Throwable $e) {
//            return $this->getError($response()->json(), $response()->status());

            return response()->json([
                "success" => true,
                "message" => "نمایش رسید:",
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
