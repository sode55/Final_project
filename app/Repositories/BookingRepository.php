<?php

namespace App\Repositories;

use App\Models\Ride;
use App\Models\Vehicle;
use App\Models\Booking;
use Illuminate\Support\Facades\DB;


class BookingRepository
{
    public function unavailableSeats($vehicleId)
    {
        $unavailableSeats = Booking::with('ride', 'vehicle_id', '=', $vehicleId)
            ->select('seat', 'gender')->pluck('gender', 'seat')->toArray();

        return $unavailableSeats;
    }

    public function allSeats($vehicleId)
    {
        $allSeats = Vehicle::find($vehicleId);
        $capacity = $allSeats->capacity;

        return $capacity;
    }

    public function save($request, $price, $userId)
    {
        for ($i = 0; $i < count($request->seat); $i++) {
            $booking = Booking::create([
                'passenger_name' => $request->passenger_name,
                'gender' => $request->gender[$i],
                'seat' => $request->seat[$i],
                'booking_price' => $price,
                'ride_id' => $request->ride_id,
                'user_id' => $userId,
            ]);
        }
        return $booking;
    }

    public function receipt($userId)
    {
        $receipt = Booking::where('bookings.user_id', '=', $userId)
        ->select(DB::raw('COUNT(seat) as passenger_number'),
            DB::raw('SUM(booking_price) as totalPrice'))->get();

        return $receipt;
    }

    public function totalPrice($userId)
{
    $totalPrice = Booking::where('bookings.user_id', '=', $userId)->sum('booking_price');

    return $totalPrice;
}
    public function VehicleId($userId)
    {
    $vehicleId =  DB::table('bookings')
        ->join('rides', 'rides.id', '=', 'bookings.ride_id')
        ->join('vehicles', 'vehicles.id', '=', 'rides.vehicle_id')
        ->where('bookings.user_id', '=', $userId)
        ->select('vehicles.id')
        ->limit(1)->pluck('vehicles.id')->toArray();

    return $vehicleId[0];
}
    public function bookingId($id)
    {
        $bookingId = Booking::with('ride')->where('ride_id', '=', $id)->get();

        return $bookingId;
    }

    public function ticket($userId)
    {
        $ticket =  DB::table('bookings')
            ->where('bookings.user_id', '=', $userId)
            ->join('rides', 'rides.id', '=', 'bookings.ride_id')
            ->join('vehicles', 'vehicles.id', '=', 'rides.vehicle_id')
            ->join('companies', 'companies.id', '=', 'vehicles.company_id')
            ->groupBy( 'passenger_name', 'origin', 'destination', 'departure_date', 'departure_time',
                'booking_price', 'model', 'name', 'company_name')
            ->select('bookings.passenger_name', 'bookings.booking_price', 'rides.origin',
                'rides.destination', 'rides.departure_date', 'rides.departure_time',
                'vehicles.model', 'vehicles.name', 'companies.company_name')
            ->addSelect(DB::raw('COUNT(seat) as passenger_number'),
                DB::raw('SUM(booking_price) as totalPrice'))
            ->limit(1)->get()->toArray();

        $seats = Booking::where('user_id', $userId)->pluck('seat')->toArray();
        $seats = implode(',', $seats);

        $ticket[] = ['seats' => $seats];

        return $ticket;
    }
}


