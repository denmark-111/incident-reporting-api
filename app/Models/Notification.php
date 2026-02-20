<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'user_id', 
        'type', 
        'message', 
        'data', 
        'read_at',
        'created_at'
    ];

}
