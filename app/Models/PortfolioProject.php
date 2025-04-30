<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PortfolioProject extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'duration_days',
        'extra_info',
    ];

    public function images()
    {
        return $this->hasMany(PortfolioImage::class);
    }
}