<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Member extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'member_id',
        'first_name',
        'middle_name',
        'last_name',
        'email',
        'phone',
        'address',
        'city',
        'province',
        'postal_code',
        'birth_date',
        'gender',
        'member_type',
        'status',
        'library_branch',
        'books_borrowed',
        'total_fines',
        'membership_date',
        'expiry_date',
        'notes',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'membership_date' => 'date',
        'expiry_date' => 'date',
        'total_fines' => 'decimal:2',
        'books_borrowed' => 'integer',
    ];

    /**
     * Get the user associated with the member.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the full name of the member.
     */
    public function getFullNameAttribute()
    {
        return trim("{$this->first_name} {$this->middle_name} {$this->last_name}");
    }
}
