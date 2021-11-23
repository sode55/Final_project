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

//       return $query->whereDate('departure_date',  $request->preferred_date)
//            ->where('origin', $request->origin)
//            ->where('destination', $request->destination);

    }

    public function scopeSelectReserve($query, $select)
    {
        $reserve_callback = function ($query) use ($select){
            $query->select($select);
        };
        return $query->with(['reserve' => $reserve_callback])->where('vehicle_id', 'id');
    }

    public function scopeSelectVehicle($query, $select)
    {
        $vehicle_callback = function ($query) use ($select){
            $query->select($select);
        };
        return $query->with(['vehicle' => $vehicle_callback])->where('vehicle_id', 'id');

    }

    public function scopeOrderByFilter($request, $query)
    {
        $orderBy = $request->input('orderBy');
        $query->when($orderBy, function ($query) use ($orderBy) {
            return $query->orderBy($orderBy, 'asc');
        });
    }

}
