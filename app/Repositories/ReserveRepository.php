<?php

namespace App\Repositories;

use App\Models\Reserve;
use Illuminate\Support\Facades\DB;

class ReserveRepository
{

//    public function list($request)
//    {
//        $reserve_select = ['origin', 'destination', 'departure_date','departure_time',
//            'No_of_sits', 'price', 'vehicle_id'];
//        $vehicle_select = ['id',  'model', 'name'];
//
//        $list = Reserve::SelectReserve($reserve_select)
//            ->SelectVehicle($vehicle_select)
//            ->filter($request)
//            ->OrderByFilter($request)
//            ->get();
//
//        return $list;
//    }

    public function list($request)
    {
        $orderBy = $request->input('orderBy');
//
//
        $list = DB::table('reserves')
                ->join('vehicles', 'reserves.vehicle_id', '=', 'vehicles.id')
                ->select(
                    'reserves.origin',
                    'reserves.destination',
                    'reserves.departure_date',
                    'reserves.departure_time',
                    'reserves.price',
                    'reserves.no_of_sits',
                    'vehicles.model',
                    'vehicles.name',
                )
            ->whereDate('departure_date', $request->preferred_date )
            ->where('origin', $request->origin)
            ->where('destination', $request->destination)
            ->when($orderBy, function ($query) use ($orderBy) {
                return $query->orderBy($orderBy, 'asc');
            })
               ->get();
        return $list;
    }
}
