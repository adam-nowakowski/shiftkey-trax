<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    protected $fillable = [
        'date',
        'miles',
        'total',
        'car_id'
    ];
}
