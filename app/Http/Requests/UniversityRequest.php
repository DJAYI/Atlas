<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UniversityRequest extends FormRequest
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
        $universityId = $this->route('university');

        return [
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:universities,code' . ($universityId ? ',' . $universityId : ''),
            'description' => 'nullable|string',
            'country_id' => 'required|exists:countries,id',
        ];
    }

    /**
     * Get custom error messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'El nombre de la universidad es obligatorio.',
            'name.max' => 'El nombre no puede tener más de 255 caracteres.',
            'code.required' => 'El código de la universidad es obligatorio.',
            'code.unique' => 'El código de la universidad ya existe.',
            'code.max' => 'El código no puede tener más de 50 caracteres.',
            'country_id.required' => 'El país es obligatorio.',
            'country_id.exists' => 'El país seleccionado no es válido.',
        ];
    }
}
