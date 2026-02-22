<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCustomFieldRequest extends FormRequest
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
            'field_label' => 'sometimes|required|string|max:255',
            'field_type' => 'sometimes|required|string|max:255',
            'field_description' => 'sometimes|nullable|string',
            'field_options' => 'sometimes|nullable|array',
            'field_rules' => 'sometimes|nullable|string|max:255',
            'is_active' => 'sometimes|boolean'
        ];
    }
}
