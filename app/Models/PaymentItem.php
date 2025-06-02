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
        'payment_method',
        'receipt_path',
        'status',
    ];

    public const PAYMENT_METHODS = [
        'cash' => 'Cash Payment',
        'bank_loan' => 'Bank Loan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isBankLoan()
    {
        return $this->payment_method === 'bank_loan';
    }

    public function isCashPayment()
    {
        return $this->payment_method === 'cash';
    }
}