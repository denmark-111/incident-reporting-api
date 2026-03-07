<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;

class CustomField extends Model
{
    use Auditable;
    
    protected $fillable = [
        'field_name',
        'field_for',
        'field_label',
        'field_type',
        'field_description',
        'field_options',
        'field_rules',
        'is_active'
    ];
}
