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
    ];

    public function counters()
    {
        return $this->hasMany(Counter::class);
    }
}
