<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dealer extends Model
{
    use HasFactory;


    protected $table = 'dealers';

    // Specify the fillable properties for mass assignment
    protected $fillable = [
        'name',
        'INN',
        'director_name',
        'ofice_adres', // Consider correcting to 'office_address'
        'store_adres', // Consider correcting to 'store_address'
        'phone_number',
        'user_id', // This is the foreign key
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function counters()
    {
        return $this->hasMany(Counter::class);
    }
}
