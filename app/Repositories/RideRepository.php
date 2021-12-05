<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use App\Models\Booking;
use App\Models\Ride;

class RideRepository
{

    public function vehicleList($request)
    {
        $vehicleList =  Ride::with(['vehicle' => function ($query){
            $query->select('id', 'name', 'model');
        }])
            ->select('origin', 'destination', 'departure_date','departure_time',
                'remaining_capacity', 'price', 'vehicle_id')
            ->whereDate('departure_date', $request->preferred_date )
            ->where('origin', $request->origin)
            ->where('destination', $request->destination)
            ->OrderBy('departure_time', 'asc')
            ->get();

        return $vehicleList;
    }

//    public function list($request)
//    {
//        $rides_select = ['origin', 'destination', 'departure_date','departure_time',
//            'remaining_capacity', 'price', 'vehicle_id'];
//        $vehicle_select = ['id',  'model', 'name'];
//
//        $list = Ride::scopeSelectRide($rides_select)
//            ->SelectVehicle($vehicle_select)
//            ->FilterBy($request)
//            ->get();
//
//        return $list;
//    }

    public function list($request)
    {
        $list = DB::table('rides')
                ->join('vehicles', 'rides.vehicle_id', '=', 'vehicles.id')
                ->select(
                    'rides.origin',
                    'rides.destination',
                    'rides.departure_date',
                    'rides.departure_time',
                    'rides.price',
                    'rides.remaining_capacity',
                    'vehicles.model',
                    'vehicles.name',
                )
            ->whereDate('departure_date', $request->preferred_date )
            ->where('origin', $request->origin)
            ->where('destination', $request->destination)
            ->orderBy( $request->input('orderBy'), 'asc')
//            ->OrderByFilter()
            ->get();

        
        return $list;
    }
    public function findAllSeats()
    {
        $allSeats = Ride::find('vehicle_id')->vehicle->capacity;

        return $allSeats;
    }

    public function findReservedSeats()
    {
       $reservedSests =  Booking::find('ride_is')->seat->count();

        return $reservedSests;
    }
}
