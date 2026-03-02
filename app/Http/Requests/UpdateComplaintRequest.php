<?php

namespace App\Http\Requests;

use App\Models\CustomField;
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
            'evidence' => 'sometimes|nullable|file|mimes:jpg,jpeg,png,pdf,mp4,mov|max:102400', // 100MB max
            'additional_notes' => 'sometimes|nullable|string',
            'witnesses' => 'sometimes|nullable|array',
            'witnesses.*.name' => 'required|string',
            'witnesses.*.contact' => 'nullable|string',

            'custom_fields' => ['sometimes', 'array'],
        ];

        if ($this->user()->isAdmin()) {
            $rules['status'] = 'sometimes|required|string|in:pending,in-progress,dispatched,on-site,resolved,rejected';
        }
        
        //Load active custom field rules for complaints
        $customFields = CustomField::where('field_for', 'complaint')
            ->where('is_active', true)
            ->get();

        foreach ($customFields as $field) {
            $rules["custom_fields.{$field->field_name}"] =
                'sometimes|' . ($field->field_rules ?? 'nullable');
        }

        return $rules;
    }
}
