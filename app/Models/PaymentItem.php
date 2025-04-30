<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'price',
        'receipt_path',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}