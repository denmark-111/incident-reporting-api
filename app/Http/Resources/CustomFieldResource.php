<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomFieldResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'field_name' => $this->field_name,
            'field_for' => $this->field_for,
            'field_label' => $this->field_label,
            'field_type' => $this->field_type,
            'field_description' => $this->field_description,
            'field_options' => json_decode($this->field_options, true),
            'field_rules' => $this->field_rules,
            'is_active' => $this->is_active
        ];
    }
}
