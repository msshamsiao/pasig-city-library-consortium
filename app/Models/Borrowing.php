<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Borrowing extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'holding_id',
        'member_id',
        'borrowed_date',
        'due_date',
        'return_date',
        'status',
        'fine_amount',
        'notes',
    ];

    protected $casts = [
        'borrowed_date' => 'datetime',
        'due_date' => 'date',
        'return_date' => 'date',
        'fine_amount' => 'decimal:2',
    ];

    /**
     * Get the holding that was borrowed.
     */
    public function holding()
    {
        return $this->belongsTo(Holding::class, 'holding_id');
    }

    /**
     * Backward compatibility - alias for holding()
     */
    public function book()
    {
        return $this->holding();
    }

    /**
     * Get the member who borrowed the book.
     */
    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    /**
     * Backward compatibility - alias for member()
     */
    public function user()
    {
        return $this->member();
    }

    /**
     * Check if the borrowing is overdue.
     */
    public function isOverdue()
    {
        return $this->status === 'borrowed' && $this->due_date < now();
    }
}
