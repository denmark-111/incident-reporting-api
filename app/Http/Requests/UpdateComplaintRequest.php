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
        $minLat = 14.70456;
        $maxLat = 14.71910;
        $minLong = 121.03043;
        $maxLong = 121.05052;

        $rules = [
            'incident_date' => 'sometimes|required|date',
            'incident_time' => 'sometimes|required|date_format:H:i',
            'location' => 'sometimes|required|string',
            'latitude' => "sometimes|required|numeric|between:$minLat,$maxLat",
            'longitude' => "sometimes|required|numeric|between:$minLong,$maxLong",
            'type' => 'sometimes|required|string',
            'severity' => 'sometimes|required|string',
            'description' => 'sometimes|required|string',
            'complainant_name' => 'sometimes|required|string',
            'complainant_contact' => 'sometimes|required|string',
            'respondent_name' => 'sometimes|required|string',
            'respondent_address' => 'sometimes|nullable|string',
            'desired_resolution' => 'sometimes|nullable|string',
            'evidence' => 'sometimes|nullable|file|mimes:jpg,jpeg,png,pdf|max:5120', // 5MB max
            'additional_notes' => 'sometimes|nullable|string',
            'witnesses' => 'sometimes|nullable|array',
            'witnesses.*.name' => 'required|string',
            'witnesses.*.contact' => 'nullable|string',
        ];

        if ($this->user()->isAdmin()) {
            $rules['status'] = 'sometimes|required|string|in:pending,dispatched,on-site,resolved,rejected';
        }

        return $rules;
    }
}
