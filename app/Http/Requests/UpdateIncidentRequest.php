<?php

namespace App\Http\Requests;

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

        return [
            'type' => 'sometimes|required|string',
            'description' => 'sometimes|required|string',
            'evidence' => 'sometimes|nullable|file|mimes:jpg,jpeg,png,pdf|max:5120', // 5MB max
            'location' => 'sometimes|required|string',
            'latitude' => "sometimes|required|numeric|between:$minLat,$maxLat",
            'longitude' => "sometimes|required|numeric|between:$minLong,$maxLong",
            'additional_notes' => 'sometimes|nullable|string',
        ];
    }
}
