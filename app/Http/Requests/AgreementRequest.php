<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AgreementRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Allow anyone who can access the controller to submit this form
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $agreementId = $this->route('agreement');
        
        return [
            'year' => 'required|integer',
            'semester' => 'required|string|max:1',
            'code' => 'required|string|max:6|unique:agreements,code' . ($agreementId ? ',' . $agreementId : ''),
            'type' => 'required|in:marco,especifico',
            'activity' => 'required|in:formacion,investigacion,extension,administrativa,otra',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
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
            'year.required' => 'El año es obligatorio.',
            'year.integer' => 'El año debe ser un número entero.',
            'semester.required' => 'El semestre es obligatorio.',
            'semester.max' => 'El semestre no puede tener más de 1 carácter.',
            'code.required' => 'El código es obligatorio.',
            'code.unique' => 'El código ya está en uso.',
            'code.max' => 'El código no puede tener más de 6 caracteres.',
            'type.required' => 'El tipo de convenio es obligatorio.',
            'type.in' => 'El tipo de convenio debe ser marco o específico.',
            'activity.required' => 'La actividad es obligatoria.',
            'activity.in' => 'La actividad debe ser formación, investigación, extensión, administrativa u otra.',
            'start_date.required' => 'La fecha de inicio es obligatoria.',
            'start_date.date' => 'La fecha de inicio debe ser una fecha válida.',
            'end_date.required' => 'La fecha de finalización es obligatoria.',
            'end_date.date' => 'La fecha de finalización debe ser una fecha válida.',
            'end_date.after_or_equal' => 'La fecha de finalización debe ser posterior o igual a la fecha de inicio.',
        ];
    }
}
