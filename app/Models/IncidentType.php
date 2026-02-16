<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncidentType extends Model
{
    /** @use HasFactory<\Database\Factories\IncidentTypeFactory> */
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'is_custom',
    ];

    public function incidents()
    {
        return $this->belongsToMany(Incident::class, 'incident_incident_type');
    }
}
