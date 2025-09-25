<?php

namespace App\Http\Requests;

use App\Models\ParkingSpace;
use Illuminate\Foundation\Http\FormRequest;

class ParkingSpaceRequest extends FormRequest
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
            'parking_number' => 'required|string|max:255|unique:parking_spaces,parking_number',
            'parking_status' => 'required|in:disponible,ocupado,en mantenimiento',
        ];

        if ($this->isMethod('put') || $this->isMethod('patch')) {
            $parkingSpaceId = $this->route('space')->id;
            $rules['parking_number'] = [
                'required',
                'string',
                'max:255',
                ParkingSpace::unique('parking_spaces', 'parking_number')->ignore($parkingSpaceId)
            ];
        }

        return $rules;
    }

    public function attributes(): array
    {
        return [
            'parking_number' => 'Número de parqueo',
            'parking_status' => 'Estado del parqueo',
        ];
    }
}
