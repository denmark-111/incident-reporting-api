<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReportRequest extends FormRequest
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
            'incident_date' => 'required|date',
            'incident_time' => 'required|date_format:H:i',
            'location' => 'required|string',
            'type' => 'required|string',
            'severity' => 'required|string',
            'description' => 'required|string',
            'complainant_name' => 'required|string',
            'complainant_contact' => 'required|string',
            'respondent_name' => 'required|string',
            'respondent_address' => 'nullable|string',
            'witness' => 'nullable|string',
            'desired_resolution' => 'nullable|string',
            'evidence' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120', // 5MB max
            'additional_notes' => 'nullable|string',
        ];
    }
}
