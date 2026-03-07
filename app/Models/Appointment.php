<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use Auditable;
    
    protected $fillable = [
        'title',
        'description',
        'scheduled_at',
        'status',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
    ];

    public function reference()
    {
        return $this->morphTo();
    }
}
