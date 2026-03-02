<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'title',
        'description',
        'scheduled_at',
        'status',
    ];

    public function reference()
    {
        return $this->morphTo();
    }
}
