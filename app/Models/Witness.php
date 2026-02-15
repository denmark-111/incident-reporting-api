<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Witness extends Model
{
    public $timestamps = false;
    
    protected $fillable = [
        'complaint_id',
        'name',
        'contact',
    ];
    
    public function complaint()
    {
        return $this->belongsTo(Complaint::class);
    }
}
