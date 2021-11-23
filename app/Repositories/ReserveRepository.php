<?php

namespace App\Repositories;

use App\Models\Reserve;

class ReserveRepository
{

    public function list($request)
    {
        $reserve_select = ['origin', 'destination', 'departure_date','departure_time',
            'No_of_sits', 'price', 'vehicle_id'];
        $vehicle_select = ['id',  'model', 'name'];

        $list = Reserve::SelectReserve($reserve_select)
            ->SelectVehicle($vehicle_select)
            ->filter($request)
            ->OrderByFilter($request)
            ->get();

        return $list;
    }

}
