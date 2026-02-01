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
            'title'       => 'required|string|max:255',
            'category'    => 'nullable|string|max:100',
            'description' => 'required|string',
            'location'    => 'nullable|string|max:255',
            'evidence'    => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120', // 5MB max
            'status'      => 'nullable|in:pending,in_progress,resolved',
        ];
    }
}
