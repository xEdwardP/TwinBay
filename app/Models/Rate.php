<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    protected $fillable = [
        'name',
        'type',
        'cost',
        'quantity',
        'grace_period_minutes'
    ];

    protected $table = 'rates';
}
