<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;

class Witness extends Model
{
    use Auditable;
    
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
