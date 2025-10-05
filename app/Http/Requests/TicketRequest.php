<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TicketRequest extends FormRequest
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
        return [
            'parking_space_id' => 'required|exists:parking_spaces,id',
            'vehicle_id'       => 'required|exists:vehicles,id',
            'rate_id'          => 'required|exists:rates,id',
            'observations'     => 'nullable|string|max:255',
        ];
    }

    public function attributes(): array
    {
        return [
            'parking_space_id' => 'Número de parqueo',
            'vehicle_id' => 'Vehículo',
            'rate_id' => 'Tarifa',
            'observations' => 'Observaciones',
        ];
    }
}
