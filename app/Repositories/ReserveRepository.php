<?php

namespace App\Repositories;

use App\Models\Reserve;

class ReserveRepository
{

//    public function list($request)
//    {
//        $reserve_select = ['origin', 'destination', 'departure_date','departure_time',
//            'No_of_sits', 'price', 'vehicle_id'];
//        $vehicle_select = ['id',  'model', 'name'];
//
//        $list = Reserve::filter($request)
//            ->SelectReserve($reserve_select)
//            ->SelectVehicle($vehicle_select)
//            ->get();
//
//        return $list;
//    }

    public function list($request)
    {
        $list =  Reserve::with(['vehicle' => function ($query){
            $query->select('id', 'name', 'model');
        }])
            ->select('origin', 'destination', 'departure_date','departure_time',
                'No_of_sits', 'price', 'vehicle_id')
            ->get();

        return $list;
    }
}
