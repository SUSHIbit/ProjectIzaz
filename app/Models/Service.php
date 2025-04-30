<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'estimated_price',
        'image_path',
        'additional_info',
    ];

    public function availabilities()
    {
        return $this->hasMany(ServiceAvailability::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}