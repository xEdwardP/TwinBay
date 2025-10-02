<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class VehicleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'customer_id' => 'required|exists:customers,id',
            'license_plate' => 'required|string|max:255|unique:vehicles,license_plate',
            'brand' => 'nullable|string|max:255',
            'model' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:255',
            'vehicle_type' => 'required|in:moto,carro,camion,otro',
        ];

        if ($this->isMethod('put') || $this->isMethod('patch')) {
            $vehicleId = $this->route('vehicle')->id ?? null;

            $rules['license_plate'] = [
                'required',
                'string',
                'max:255',
                Rule::unique('vehicles', 'license_plate')->ignore($vehicleId),
            ];
        }

        return $rules;
    }
}
