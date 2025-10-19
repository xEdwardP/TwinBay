<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PrintReportFilterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
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
            'start_date' => 'required|date_format:Y-m-d',
            'end_date' => 'required|date_format:Y-m-d|after_or_equal:start_date',
        ];
    }

    public function messages()
    {
        return [
            'start_date.required' => 'Debes ingresar una fecha de inicio.',
            'start_date.date_format' => 'La fecha de inicio debe tener el formato YYYY-MM-DD.',
            'end_date.required' => 'Debes ingresar una fecha final.',
            'end_date.date_format' => 'La fecha final debe tener el formato YYYY-MM-DD.',
            'end_date.after_or_equal' => 'La fecha final no puede ser menor que la fecha de inicio.',
        ];
    }
}
