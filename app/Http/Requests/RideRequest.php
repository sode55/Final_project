<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RideRequest extends FormRequest
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
            'origin' => 'required|string',
            'destination' => 'required|string',
            'departure_date' => 'required|date_format:Y-m-d',
            'departure_time' => 'required',
            'price' => 'required',
            'vehicle_id' => 'required'
        ];
    }
}
