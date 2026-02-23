<?php

namespace App\Http\Requests;

use App\Models\CustomField;
use Illuminate\Foundation\Http\FormRequest;

class StoreComplaintRequest extends FormRequest
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
            'incident_date' => 'required|date',
            'incident_time' => 'required|date_format:H:i',
            'location' => 'required|string',
            'latitude' => "required|numeric|between:$minLat,$maxLat",
            'longitude' => "required|numeric|between:$minLong,$maxLong",
            'type' => 'required|string',
            'severity' => 'required|string',
            'description' => 'required|string',
            'complainant_name' => 'required|string',
            'complainant_contact' => 'required|string',
            'respondent_name' => 'required|string',
            'respondent_address' => 'nullable|string',
            'desired_resolution' => 'nullable|string',
            'evidence' => 'nullable|file|mimes:jpg,jpeg,png,pdf,mp4,mov|max:102400', // 100MB max
            'additional_notes' => 'nullable|string',
            'witnesses' => 'nullable|array',
            'witnesses.*.name' => 'required|string',
            'witnesses.*.contact' => 'nullable|string',
        ];

        //Load active custom field rules for complaints
        $customFields = CustomField::where('field_for', 'complaint')
            ->where('is_active', true)
            ->get();

        foreach ($customFields as $field) {
            $rules["custom_fields.{$field->field_name}"] = $field->field_rules ?? 'nullable';
        }

        return $rules;
    }
}
