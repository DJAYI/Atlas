<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAssistanceRequest extends FormRequest
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
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'second_last_name' => 'nullable|string|max:255',
            'personal_email' => 'required|email|max:255',
            'institutional_email' => 'nullable|email|max:255',
            'phone_number' => 'nullable|string|max:20',
            'country_of_origin' => 'required|exists:countries,id',
            'origin_university' => 'required|exists:universities,id',
            'academic_program' => 'required|exists:careers,id',
            'biological_sex' => 'required|string|max:10',
            'birth_date' => 'required|date',
            'minority_group' => 'nullable|string|max:255',
            'type' => 'required|string|max:50',
            'destination_university' => 'required|exists:universities,id',
            'mobility_id' => 'required|exists:mobilities,id',
            'identity_document' => 'nullable|sometimes|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'cf-turnstile-response' => 'required|string',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'first_name.required' => __('El nombre es obligatorio'),
            'last_name.required' => __('El apellido es obligatorio'),
            'personal_email.required' => __('El correo electrónico es obligatorio'),
            'personal_email.email' => __('El correo electrónico debe ser válido'),
            'institutional_email.email' => __('El correo institucional debe ser válido'),
            'country_of_origin.required' => __('El país de origen es obligatorio'),
            'country_of_origin.exists' => __('El país seleccionado no es válido'),
            'origin_university.required' => __('La universidad de origen es obligatoria'),
            'origin_university.exists' => __('La universidad seleccionada no es válida'),
            'academic_program.required' => __('El programa académico es obligatorio'),
            'academic_program.exists' => __('El programa académico seleccionado no es válido'),
            'biological_sex.required' => __('El sexo biológico es obligatorio'),
            'birth_date.required' => __('La fecha de nacimiento es obligatoria'),
            'birth_date.date' => __('La fecha de nacimiento debe ser válida'),
            'type.required' => __('El tipo de movilidad es obligatorio'),
            'destination_university.required' => __('La universidad de destino es obligatoria'),
            'destination_university.exists' => __('La universidad de destino seleccionada no es válida'),
            'mobility_id.required' => __('El tipo de movilidad es obligatorio'),
            'mobility_id.exists' => __('El tipo de movilidad seleccionado no es válido'),
            'identity_document.mimes' => __('El documento de identidad debe ser una imagen (jpg, jpeg, png) o un PDF'),
            'identity_document.max' => __('El documento de identidad no debe exceder los 2MB'),
            'cf-turnstile-response.required' => __('La verificación de seguridad es obligatoria'),
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'first_name' => trim($this->first_name),
            'last_name' => trim($this->last_name),
            'personal_email' => trim(strtolower($this->personal_email)),
            'institutional_email' => $this->institutional_email ? trim(strtolower($this->institutional_email)) : null,
        ]);
    }
}
