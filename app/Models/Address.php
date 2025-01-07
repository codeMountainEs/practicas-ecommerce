<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Address extends Model
{
    protected $fillable = [
        'order_id',
        'first_name',
        'last_name',
        'phone',
        'street_address',
        'city',
        'state',
        'zip_code',
    ];

    public function order():BelongsTo {
        return $this->belongsTo(Order::class);
    }

    public function getNombreCompletoAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }
}
