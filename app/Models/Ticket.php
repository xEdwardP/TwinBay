<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'parking_space_id',
        'customer_id',
        'vehicle_id',
        'rate_id',
        'user_id',
        'ticket_number',
        'in_date',
        'in_time',
        'out_date',
        'out_time',
        'total_time',
        'total_amount',
        'ticket_status',
        'observations'
    ];

    protected $table = 'tickets';

    public function parkingSpace()
    {
        return $this->belongsTo(ParkingSpace::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function rate()
    {
        return $this->belongsTo(Rate::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }
}
