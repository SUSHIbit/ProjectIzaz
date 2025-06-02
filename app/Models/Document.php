<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'category',
        'description',
        'document_type',
        'file_path',
        'lawyer_id',
        'status',
        'requires_signature',
        'signed_file_path',
        'expiry_date',
        'is_required',
        'version'
    ];

    protected $casts = [
        'requires_signature' => 'boolean',
        'is_required' => 'boolean',
        'expiry_date' => 'date',
    ];

    // Document categories
    const CATEGORIES = [
        'identification' => 'Identification Documents',
        'legal' => 'Legal Documents',
        'financial' => 'Financial Documents',
        'property' => 'Property Documents',
        'other' => 'Other Documents'
    ];

    public function lawyer()
    {
        return $this->belongsTo(User::class, 'lawyer_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function signDocuments()
    {
        return $this->hasMany(\App\Models\SignDocument::class, 'document_id');
    }

    public function isExpired()
    {
        return $this->expiry_date && $this->expiry_date->isPast();
    }

    public function needsRenewal()
    {
        return $this->expiry_date && $this->expiry_date->subDays(30)->isPast();
    }

    public function getCategoryName()
    {
        return self::CATEGORIES[$this->category] ?? 'Uncategorized';
    }
}