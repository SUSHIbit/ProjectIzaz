<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UpdateImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_update_id',
        'image_path',
    ];

    public function update()
    {
        return $this->belongsTo(UserUpdate::class, 'user_update_id');
    }
}