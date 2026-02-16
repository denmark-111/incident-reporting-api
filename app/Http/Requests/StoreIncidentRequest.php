<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreIncidentRequest extends FormRequest
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
        
        return [
            'description' => 'required|string',
            'evidence' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120', // 5MB max
            'location' => 'required|string',
            'latitude' => "required|numeric|between:$minLat,$maxLat",
            'longitude' => "required|numeric|between:$minLong,$maxLong",
            'additional_notes' => 'nullable|string',

            'types' => ['sometimes', 'array', 'min:1'],
            'types.*' => ['integer', 'exists:incident_types,id'],

            'custom_types' => ['sometimes', 'array'],
            'custom_types.*' => ['string', 'max:100'],
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {

            $types = $this->input('types', []);
            $custom = $this->input('custom_types', []);

            $hasDefault = is_array($types) && count($types) > 0;
            $hasCustom = is_array($custom) && count($custom) > 0;

            if (! $hasDefault && ! $hasCustom) {
                $validator->errors()->add(
                    'types',
                    'At least one incident type (default or custom) is required.'
                );
            }
        });
    }
}
