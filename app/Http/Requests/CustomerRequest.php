<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CustomerRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'document_type' => 'required|in:DNI,Pasaporte,Licencia de conducir,Carnet de extranjero',
            'document_number' => 'required|string|max:50|unique:customers,document_number',
            'email' => 'nullable|email|max:255',
            'phone' => 'required|string|max:20',
            'genre' => 'required|in:Masculino,Femenino,Otro',
            'is_active' => 'boolean',
        ];

        if ($this->isMethod('put') || $this->isMethod('patch')) {
            $customerId = $this->route('customer')->id ?? null;

            $rules['document_number'] = [
                'required',
                'string',
                'max:50',
                Rule::unique('customers', 'document_number')->ignore($customerId),
            ];
        }

        return $rules;
    }

    public function attributes(): array
    {
        return [
            'document_type' => 'tipo de documento',
            'document_number' => 'número de documento',
            'genre' => 'género',
        ];
    }
}
