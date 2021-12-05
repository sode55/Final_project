<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ride extends Model
{
    use HasFactory;

    protected $table = 'rides';

    protected $guarded = ['id'];

    protected $hidden = ['vehicle_id', 'id'];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function scopeFilter($query, $request)
    {
        $query->when($request->preferred_date ?? false,
            function ($query) use ($request) {
                return $query->whereDate('departure_date', $request);
            }, $request->origin ?? false,
            function ($query) use ($request) {
                return $query->where('origin', $request);
            }, $request->destination ?? false,
            function ($query) use ($request) {
                return $query->where('destination', $request);
            });

    }

    public function scopeSelectRide($query, $select)
    {
        $ride_callback = function ($query) use ($select){
            $query->select($select);
        };
        return $query->with(['ride' => $ride_callback])->where('vehicle_id', 'id');
    }

    public function scopeSelectVehicle($query, $select)
    {
        $vehicle_callback = function ($query) use ($select){
            $query->select($select);
        };
        return $query->with(['vehicle' => $vehicle_callback])->where('vehicle_id', 'id');

    }

    public function scopeOrderByFilter($query, $request)
    {
        return $query->orderBy($request->input('orderBy'), 'desc');
    }


//    public function scopeFilter($query, $sort, $request)
//    {
////        foreach ($sort as $column => $direction) {
////            $query->orderBy($column, $direction);
////        }
////
////        return $query;
//
//        foreach ($request->get($request->orderBy) as $column => $direction) {
//            $query->orderBy($column, $direction);
//        }
//            return $query;
//    }

}
