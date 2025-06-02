<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SignDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'document_id',
        'user_id',
        'file_path',
    ];
}
