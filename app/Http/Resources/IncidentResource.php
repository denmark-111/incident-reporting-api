<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IncidentResource extends JsonResource
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
            'status' => $this->status,
            'description' => $this->description,
            'evidence' => $this->evidence_path ? asset('storage/' . $this->evidence_path) : null,
            'location' => $this->location,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'additional_notes' => $this->additional_notes,

            'types' => $this->whenLoaded('types', function () {
                return $this->types->map(fn($t) => [
                    'id' => $t->id,
                    'name' => $t->name,
                    'is_custom' => $t->is_custom,
                ]);
            }),

            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
