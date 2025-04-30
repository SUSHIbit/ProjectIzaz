<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PortfolioImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'portfolio_project_id',
        'image_path',
    ];

    public function project()
    {
        return $this->belongsTo(PortfolioProject::class, 'portfolio_project_id');
    }
}