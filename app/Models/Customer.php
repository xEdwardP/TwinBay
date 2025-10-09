<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'document_type',
        'document_number',
        'email',
        'phone',
        'genre',
        'is_active'
    ];

    protected $table = "customers";

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
}
