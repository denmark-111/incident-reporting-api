<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateComplaintRequest extends FormRequest
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
            'incident_date' => 'sometimes|date',
            'incident_time' => 'sometimes|date_format:H:i',
            'location' => 'sometimes|string',
            'type' => 'sometimes|string',
            'severity' => 'sometimes|string',
            'description' => 'sometimes|string',
            'complainant_name' => 'sometimes|string',
            'complainant_contact' => 'sometimes|string',
            'respondent_name' => 'sometimes|string',
            'respondent_address' => 'nullable|string',
            'witness' => 'nullable|string',
            'desired_resolution' => 'nullable|string',
            'evidence' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120', // 5MB max
            'additional_notes' => 'nullable|string',
        ];
    }
}
