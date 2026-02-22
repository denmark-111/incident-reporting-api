<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCustomFieldRequest extends FormRequest
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
            'field_for' => 'required|in:incident,complaint',
            'field_label' => 'required|string|max:255',
            'field_type' => 'required|string|max:255',
            'field_description' => 'nullable|string',
            'field_options' => 'nullable|array',
            'field_rules' => 'nullable|string|max:255',
            'is_active' => 'boolean'
        ];
    }
}
