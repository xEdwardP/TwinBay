<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table = 'settings';
    protected $fillable = [
        'name',
        'description',
        'branch',
        'address',
        'phone1',
        'phone2',
        'logo',
        'logo_auto',
        'currency',
        'email',
        'website'
    ];
}
