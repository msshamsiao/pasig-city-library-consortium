<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'title',
        'author',
        'isbn',
        'category',
        'status',
        'borrowed_by',
        'borrowed_date',
        'due_date',
        'total_copies',
        'available_copies',
        'description',
        'cover_image',
    ];

    protected $casts = [
        'borrowed_date' => 'date',
        'due_date' => 'date',
    ];

    // Relationship with user who borrowed
    public function borrower()
    {
        return $this->belongsTo(User::class, 'borrowed_by');
    }

    // Scopes
    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }

    public function scopeBorrowed($query)
    {
        return $query->where('status', 'borrowed');
    }

    public function scopeReserved($query)
    {
        return $query->where('status', 'reserved');
    }

    public function scopeCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    // Check if book is available
    public function isAvailable()
    {
        return $this->status === 'available' && $this->available_copies > 0;
    }

    // Get status badge color
    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'available' => 'green',
            'borrowed' => 'orange',
            'reserved' => 'blue',
            default => 'gray',
        };
    }
}
