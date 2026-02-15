<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ComplaintResource extends JsonResource
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
            'incident_date' => $this->incident_date,
            'incident_time' => $this->incident_time,
            'location' => $this->location,
            'type' => $this->type,
            'severity' => $this->severity,
            'description' => $this->description,
            'complainant_name' => $this->complainant_name,
            'complainant_contact' => $this->complainant_contact,
            'respondent_name' => $this->respondent_name,
            'respondent_address' => $this->respondent_address,

            'witnesses' => $this->whenLoaded('witnesses', function () {
                return $this->witnesses->map(function ($witness) {
                    return [
                        'name' => $witness->name,
                        'contact' => $witness->contact,
                    ];
                });
            }),
            
            'desired_resolution' => $this->desired_resolution,
            'evidence' => $this->evidence_path ? asset('storage/' . $this->evidence_path) : null,
            'additional_notes' => $this->additional_notes,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
