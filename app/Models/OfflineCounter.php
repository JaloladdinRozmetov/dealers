<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfflineCounter extends Model
{
    use HasFactory;

    protected $fillable = [
        'serial_number',
        'caliber',
        'name',
        'production_time',
        'producer_country',
        'supplier',
        'phone_number',
        'hash'
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            if (empty($model->hash)) {
                $model->hash = md5(uniqid((string) $model->serial_number, true));
            }
        });
    }
}
