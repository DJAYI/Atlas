<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'responsable' => 'required|string|max:255',
            'activity_id' => 'required|exists:activities,id',
            'has_agreement' => 'required|in:si,no',
            'agreement_id' => 'nullable|required_if:has_agreement,si|exists:agreements,id',
            'modality' => 'required|in:presencial,virtual,en casa',
            'location' => 'required|in:nacional,internacional,local',
            'internationalization_at_home' => 'nullable|in:si,no',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
            'universities' => 'required|array',
            'universities.*' => 'exists:universities,id',
            'description' => 'nullable|string|max:1000',
            'career_id' => 'nullable|exists:careers,id',
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
            'name.required' => 'El nombre del evento es obligatorio.',
            'name.max' => 'El nombre del evento no puede tener más de 255 caracteres.',
            'responsable.required' => 'El responsable del evento es obligatorio.',
            'responsable.max' => 'El nombre del responsable no puede tener más de 255 caracteres.',
            'activity_id.required' => 'La actividad es obligatoria.',
            'activity_id.exists' => 'La actividad seleccionada no es válida.',
            'has_agreement.required' => 'Debe indicar si el evento tiene un acuerdo asociado.',
            'has_agreement.in' => 'El valor debe ser "si" o "no".',
            'agreement_id.required_if' => 'El acuerdo es obligatorio cuando se indica que hay un acuerdo asociado.',
            'agreement_id.exists' => 'El acuerdo seleccionado no es válido.',
            'modality.required' => 'La modalidad es obligatoria.',
            'modality.in' => 'La modalidad debe ser presencial, virtual o en casa.',
            'location.required' => 'La ubicación es obligatoria.',
            'location.in' => 'La ubicación debe ser nacional, internacional o local.',
            'internationalization_at_home.in' => 'El valor debe ser "si" o "no".',
            'start_date.required' => 'La fecha de inicio es obligatoria.',
            'start_date.date' => 'La fecha de inicio debe ser una fecha válida.',
            'end_date.required' => 'La fecha de finalización es obligatoria.',
            'end_date.date' => 'La fecha de finalización debe ser una fecha válida.',
            'end_date.after_or_equal' => 'La fecha de finalización debe ser posterior o igual a la fecha de inicio.',
            'start_time.required' => 'La hora de inicio es obligatoria.',
            'start_time.date_format' => 'La hora de inicio debe tener un formato válido (HH:MM).',
            'end_time.required' => 'La hora de finalización es obligatoria.',
            'end_time.date_format' => 'La hora de finalización debe tener un formato válido (HH:MM).',
            'universities.required' => 'Debe seleccionar al menos una universidad.',
            'universities.array' => 'Las universidades deben ser un conjunto de valores.',
            'universities.*.exists' => 'Una o más de las universidades seleccionadas no son válidas.',
            'description.max' => 'La descripción no puede tener más de 1000 caracteres.',
            'career_id.exists' => 'La carrera seleccionada no es válida.',
        ];
    }
}
