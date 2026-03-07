<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;

class CustomFieldValue extends Model
{
    use Auditable;
    
    protected $fillable = [
        'custom_field_id',
        'complaint_id',
        'incident_id',
        'value'
    ];

    public function customField()
    {
        return $this->belongsTo(CustomField::class);
    }
}
