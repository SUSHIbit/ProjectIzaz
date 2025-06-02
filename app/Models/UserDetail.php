<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserDetail extends Model
{
    protected $fillable = [
        'user_id',
        'service_id',
        'house_type',
        'payment_type',
        'notes'
    ];

    /**
     * Get the user that owns the detail.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the service associated with the detail.
     */
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    /**
     * Get the house type options.
     */
    public static function getHouseTypes(): array
    {
        return [
            'apartment' => 'Apartment',
            'house' => 'House',
            'villa' => 'Villa',
            'condo' => 'Condominium',
            'townhouse' => 'Townhouse'
        ];
    }

    /**
     * Get the payment type options.
     */
    public static function getPaymentTypes(): array
    {
        return [
            'cash' => 'Cash Payment',
            'bank_loan' => 'Bank Loan'
        ];
    }
} 