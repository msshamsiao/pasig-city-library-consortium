<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Library extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'address',
        'phone',
        'website',
        'contact_person',
        'position',
        'logo',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Scope a query to only include active libraries.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
