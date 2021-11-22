<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reserve extends Model
{
    use HasFactory;

    protected $table = 'reserves';

    protected $guarded = ['id'];

    protected $hidden = ['vehicle_id'];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function scopeFilter($query, $request)
    {
//        $query->when($request->preferred_date ?? false,
//            fn($query, $request) => $query->whereDate('preferred_date', $request))
//            ->when($request->origin ?? false,
//                fn($query, $request) => $query->where('origin', $request))
//            ->when($request->destination ?? false,
//                fn($query, $request) => $query->where('destination', $request));

//        $query->when($request->preferred_date ?? false,
//            function ($query) use ($request) {
//                return $query->whereDate('preferred_date', $request);
//            })
//            ->when($request->origin ?? false,
//                function ($query) use ($request) {
//                    return $query->where('origin', $request);
//                })
//            ->when($request->destination ?? false,
//                function ($query) use ($request) {
//                    return $query->where('destination', $request);
//                });

        $query->whereDate('departure_date',  $request->preferred_date)
            ->where('origin', $request->origin)
            ->where('destination', $request->destination);

    }

//    public function scopeSelectReserve($query, $select)
//    {
//        $reserve_callback = function ($query) use ($select){
//            $query->select($select);
//        };
//        return $query->with(['reserve' => $reserve_callback]);
//    }

//    public function scopeSelectVehicle($query, $select)
//    {
//        $vehicle_callback = function ($query) use ($select){
//            $query->select($select);
//        };
//        return $query->with(['vehicle' => $vehicle_callback]);
//
//    }


}
