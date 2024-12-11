<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'organization_name',
        'organization_INN',
        'director_name',
        'counter_address',
        'phone_number',
        'personal_account_number',
        'region_id'
    ];

    public function counters()
    {
        return $this->hasMany(Counter::class);
    }

    public function region()
    {
        return $this->belongsTo(Region::class);
    }
}
