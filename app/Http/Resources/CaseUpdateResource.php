<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CaseUpdateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
                'role' => $this->user->role,
            ],
            'event_type' => $this->event_type,
            'old_status' => $this->old_status,
            'new_status' => $this->new_status,
            'message' => $this->message,
            'attachment' => $this->attachment_path ? asset('storage/' . $this->attachment_path) : null,
            'created_at' => $this->created_at,
        ];
    }
}
