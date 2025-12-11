<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Holding extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $fillable = [
        'holding_branch_id',
        'title',
        'author',
        'isbn',
        'category',
        'status',
        'total_copies',
        'available_copies',
        'description',
        'cover_image',
    ];

    // Relationship with library (holding branch)
    public function library()
    {
        return $this->belongsTo(Library::class, 'holding_branch_id');
    }

    // Relationship with borrowings
    public function borrowings()
    {
        return $this->hasMany(Borrowing::class, 'holding_id');
    }

    // Current active borrowing
    public function currentBorrowing()
    {
        return $this->hasOne(Borrowing::class, 'holding_id')->where('status', 'borrowed');
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

    // Check if holding is available
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
