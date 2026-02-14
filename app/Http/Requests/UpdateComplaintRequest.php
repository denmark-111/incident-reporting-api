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
            'incident_date' => 'sometimes|required|date',
            'incident_time' => 'sometimes|required|date_format:H:i',
            'location' => 'sometimes|required|string',
            'type' => 'sometimes|required|string',
            'severity' => 'sometimes|required|string',
            'description' => 'sometimes|required|string',
            'complainant_name' => 'sometimes|required|string',
            'complainant_contact' => 'sometimes|required|string',
            'respondent_name' => 'sometimes|required|string',
            'respondent_address' => 'sometimes|nullable|string',
            'witness' => 'sometimes|nullable|string',
            'desired_resolution' => 'sometimes|nullable|string',
            'evidence' => 'sometimes|nullable|file|mimes:jpg,jpeg,png,pdf|max:5120', // 5MB max
            'additional_notes' => 'sometimes|nullable|string',
        ];
    }
}
