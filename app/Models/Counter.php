<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Counter extends Model
{
    use HasFactory;

    protected $fillable = [
        'serial_number',
        'caliber',
        'imei',
        'iccid',
        'phone_number',
        'dealer_id',
        'customer_id'
    ];

    /**
     * Get the dealer associated with the counter.
     */
    public function dealer()
    {
        return $this->belongsTo(Dealer::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
