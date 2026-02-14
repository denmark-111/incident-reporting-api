<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    /** @use HasFactory<\Database\Factories\ComplaintFactory> */
    use HasFactory;

    protected $fillable = [
        'incident_date',
        'incident_time',
        'location',
        'type',
        'severity',
        'description',
        'complainant_name',
        'complainant_contact',
        'respondent_name',
        'respondent_address',
        'witness',
        'desired_resolution',
        'evidence_path',
        'additional_notes',
        'user_id',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
