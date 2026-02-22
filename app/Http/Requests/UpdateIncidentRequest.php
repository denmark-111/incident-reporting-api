<?php

namespace App\Http\Requests;

use App\Models\CustomField;
use Illuminate\Foundation\Http\FormRequest;

class UpdateIncidentRequest extends FormRequest
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
            'description' => 'sometimes|required|string',
            'evidence' => 'sometimes|nullable|file|mimes:jpg,jpeg,png,pdf|max:102400', // 100MB max
            'location' => 'sometimes|required|string',
            'latitude' => "sometimes|required|numeric|between:$minLat,$maxLat",
            'longitude' => "sometimes|required|numeric|between:$minLong,$maxLong",
            'additional_notes' => 'sometimes|nullable|string',

            'types' => ['sometimes', 'array', 'min:1'],
            'types.*' => ['integer', 'exists:incident_types,id'],

            'custom_types' => ['sometimes', 'array'],
            'custom_types.*' => ['string', 'max:100'],

            'custom_fields' => ['sometimes', 'array'],
        ];

        if ($this->user()->isAdmin()) {
            $rules['status'] = 'sometimes|required|string|in:pending,dispatched,on-site,resolved,rejected';
        }

        //Load active custom field rules for incidents
        $customFields = CustomField::where('field_for', 'incident')
            ->where('is_active', true)
            ->get();

        foreach ($customFields as $field) {
            $rules["custom_fields.{$field->field_name}"] =
                'sometimes|' . ($field->field_rules ?? 'nullable');
        }

        return $rules;
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {

            $typesPresent = $this->has('types');
            $customPresent = $this->has('custom_types');

            // Only enforce if updating types
            if ($typesPresent || $customPresent) {

                $types = $this->input('types', []);
                $custom = $this->input('custom_types', []);

                $hasDefault = is_array($types) && count($types) > 0;
                $hasCustom = is_array($custom) && count($custom) > 0;

                if (! $hasDefault && ! $hasCustom) {
                    $validator->errors()->add(
                        'types',
                        'At least one incident type must be provided when updating types.'
                    );
                }
            }
        });
    }
}
