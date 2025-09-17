<?php

namespace App\Http\Requests;

use App\Models\Setting;
use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
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
            'name'        => 'required|string|max:255',
            'description' => 'required|string',
            'branch'      => 'required|string|max:150',
            'address'     => 'required|string',
            'phone1'      => 'required|string|max:30',
            'phone2'      => 'nullable|string|max:30',
            'logo'        => 'image|mimes:jpeg,png,jpg,svg|max:2048',
            'logo_auto'   => 'image|mimes:jpeg,png,jpg,svg|max:2048',
            'currency'    => 'required|string|max:30',
            'email'       => 'required|email|max:255',
            'website'     => 'nullable|url|max:255',
        ];
    }

    // Validacion para imagenes
    public function withValidator($validator)
    {
        $setting = Setting::first();

        $validator->sometimes('logo', 'required', function () use ($setting) {
            return !$setting || !$setting->logo;
        });

        $validator->sometimes('logo_auto', 'required', function () use ($setting) {
            return !$setting || !$setting->logo_auto;
        });
    }
}
