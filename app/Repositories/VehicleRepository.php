<?php

namespace App\Repositories;

use App\Models\Vehicle;

class VehicleRepository
{
    public function save($request)
    {
        $vehicle = Vehicle::create([
            'name' => $request->name,
            'model' => $request->model,
            'accessories' => $request->accessories,
            'capacity' => $request->capacity,
            'plate_number' => $request->plate_number,
            'company_id' => $request->company_id,
        ]);

        return $vehicle;
    }

    public function edit($request, $id)
    {
        $input = $request->all();
        $vehicle = Vehicle::find($id);
        $vehicle->name = $input['name'];
        $vehicle->model = $input['model'];
        $vehicle->accessories = $input['accessories'];
        $vehicle->capacity = $input['capacity'];
        $vehicle->plate_number = $input['plate_number'];
        $vehicle->save();

        return $vehicle;
    }

    public function destroy($id)
    {
        $vehicle = Vehicle::find($id);
        $vehicle->delete();

        return $vehicle;
    }

    public function list()
    {
        $vehicle = Vehicle::onlyTrashed()->get();

        return $vehicle;
    }

}
