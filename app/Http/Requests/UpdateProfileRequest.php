<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
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
        $rules = [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'phone' => 'required|string|max:20',
            'document_type' => 'required|string|in:DNI,Pasaporte,Licencia de conducir,Carnet de extranjero',
            'document_number' => 'required|string|max:50|unique:users,document_number',
            'birthday' => 'required|date|before_or_equal:today',
            'genre' => 'required|string|in:Masculino,Femenino,Otro',
            'userphoto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'address' => 'required|string|max:255',
            'contact_name' => 'required|string|max:255',
            'contact_phone' => 'required|string|max:20',
            'contact_relationship' => 'required|string|max:255',
        ];

        if ($this->isMethod('put') || $this->isMethod('patch')) {
            $userId = $this->route('user')->id ?? null;

            $rules['email'] = [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($userId),
            ];

            $rules['document_number'] = [
                'required',
                'string',
                'max:50',
                Rule::unique('users', 'document_number')->ignore($userId),
            ];
        }

        return $rules;
    }

    public function attributes(): array
    {
        return [
            'first_name' => 'nombres',
            'last_name' => 'apellidos',
            'birthday' => 'fecha de nacimiento',
            'document_type' => 'tipo de documento',
            'document_number' => 'número de documento',
            'contact_name' => 'nombre del contacto de emergencia',
            'contact_phone' => 'teléfono del contacto de emergencia',
            'contact_relationship' => 'relación o parentesco',
            'genre' => 'género',
            'userphoto' => 'foto de perfil',
        ];
    }
}
