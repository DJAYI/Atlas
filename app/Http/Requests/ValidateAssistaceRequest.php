<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidateAssistaceRequest extends FormRequest
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
            'document_type' => 'required|string|in:DNI,PP,CC,CE,TI,CA,Otro',
            'document_number' => 'required|string|numeric|max:30',
            'event_code' => 'required|string|exists:events,event_code',
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
            'document_type.required' => __('El tipo de documento es obligatorio'),
            'document_type.in' => __('El tipo de documento seleccionado no es válido'),
            'document_number.required' => __('El número de documento es obligatorio'),
            'document_number.string' => __('El número de documento debe ser una cadena de texto'),
            'document_number.numeric' => __('El número de documento debe ser numérico'),
            'document_number.max' => __('El número de documento no debe exceder los 30 caracteres'),
            'event_code.required' => __('El código del evento es obligatorio'),
            'event_code.exists' => __('El código del evento no es válido o no existe'),
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
            'document_number' => trim($this->input('document_number')),
            'event_code' => trim(strtoupper($this->input('event_code'))),
        ]);
    }
}
