<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VehicleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'vehicle_name' => 'required|string',
            'vehicle_model' => 'required|string',
            'vehicle_accessories' => 'required',
            'number_of_sits' => 'required|Numeric',
            'plate_number' => 'required|string',
            'origin' => 'required|string',
            'destination' => 'required|string',
            'departure_date' => 'required|date_format:Y-m-d',
            'departure_time' => 'required',
            'company_id' => 'required',
        ];
    }
}
