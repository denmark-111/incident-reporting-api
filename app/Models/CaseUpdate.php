<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CaseUpdate extends Model
{
    protected $fillable = [
        'reference_type',
        'reference_id',
        'user_id',
        'event_type',
        'old_status',
        'new_status',
        'message',
    ];

    public function reference()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
