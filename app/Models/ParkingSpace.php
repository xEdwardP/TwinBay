<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParkingSpace extends Model
{
    protected $fillable = [
        'parking_number',
        'parking_status'
    ];

    protected $table = "parking_spaces";

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
