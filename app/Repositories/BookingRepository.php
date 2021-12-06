<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use App\Models\Booking;
use App\Models\Vehicle;
use App\Models\Ride;

class BookingRepository
{
    public function availableSeats($vehicleId)
    {

        $unavailableSeats = Booking::with('ride', 'vehicle_id', '=', $vehicleId)
            ->select('seat', 'gender')->pluck('gender', 'seat')->toArray();

        foreach ($unavailableSeats as $seat => $gender)
        {
            $seatArray[] = explode(',', $seat);
            $singleSeatArray = array_reduce($seatArray, 'array_merge', array());

            $genderArray[] = explode(',', $gender);
            $singleGenderArray = array_reduce($genderArray, 'array_merge', array());

            $output[] = ['seat' => $singleSeatArray, 'gender' => $singleGenderArray];
            $singleOutputArray = array_reduce($output, 'array_merge', array());

            $seat = $singleOutputArray['seat'];
            $gender = $singleOutputArray['gender'];

            $reservedSeat = array_combine($seat, $gender);

            $allSeats =   Vehicle::find($vehicleId);
            $number_of_seats = $allSeats->capacity;
            $allSeatsArray = array_fill(1, $number_of_seats,'0' );


            $availableSeats = array_merge_recursive_distinct($allSeatsArray, $reservedSeat);

        }

        return $availableSeats;

    }

    public function receipt($userId)
    {

        $receipt =  DB::table('bookings')
            ->where('bookings.user_id', '=', $userId)
            ->join('rides', 'rides.id', '=', 'bookings.ride_id')
            ->groupBy('price')
            ->select(DB::raw('COUNT(seat) as passenger_number'),
                DB::raw('SUM(price) as totalPrice'))
           ->get();

        return $receipt;
    }

    public function allSeats($vehicleId)
    {
        $allSeats =   Vehicle::find($vehicleId);
        $seats = $allSeats->capacity;
        $seatsArray = array_fill(1, $seats,'0' );

        return $seatsArray;
    }

public function findVehicleId()
{
    $vehicleId =  DB::table('bookings')
        ->join('rides', 'rides.id', '=', 'bookings.ride_id')
        ->join('vehicles', 'vehicles.id', '=', 'rides.vehicle_id')
        ->select(
            'vehicles.id',
        )
        ->pluck('id')->toArray();
    $vehicleId = $vehicleId[array_key_first($vehicleId)];


    return $vehicleId;
}
    public function bookingId($id)
    {
        $bookingId = Booking::with('ride')->where('ride_id', '=', $id)->get();

        return $bookingId;
    }

//    public function $ticket()
//    {
        //        $ticket =  DB::table('bookings')
//            ->where('bookings.user_id', '=', $userId)
//            ->join('rides', 'rides.id', '=', 'bookings.ride_id')
//            ->join('vehicles', 'vehicles.id', '=', 'rides.vehicle_id')
//            ->groupBy( 'passenger_name', 'origin', 'destination', 'departure_date', 'departure_time',
//                'price', 'model', 'name')
//            ->select('bookings.passenger_name', 'rides.origin', 'rides.destination',
//                'rides.departure_date', 'rides.departure_time', 'rides.price',
//                'vehicles.model', 'vehicles.name')
//            ->addSelect(DB::raw('COUNT(seat) as passenger_number'),
//                DB::raw('SUM(price) as totalPrice'))
//            ->limit(1)->get()->toArray();

//        $seats = Booking::where('user_id', $userId)->pluck('seat')->toArray();
//        $seats = implode(',', $seats);
//
//        $ticket[] = ['seats' => $seats];

        return $ticket;
//    }

}


