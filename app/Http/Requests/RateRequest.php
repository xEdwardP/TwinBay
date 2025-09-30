<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RateRequest extends FormRequest
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
            'name' => 'required|in:regular,nocturna,fin de semana,feriados',
            'type' => 'required|in:por hora,por dia',
            'cost' => 'required|numeric|min:0|max:99999999.99',
            'quantity' => 'required|integer|min:1|max:10000',
            'grace_period_minutes' => 'required|integer|min:0|max:1440',
        ];
    }

    public function attributes(): array
    {
        return [
            'cost' => 'Costo',
            'grace_period_minutes' => 'Minutos de gracia',
        ];
    }
}
