<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookRequest extends Model
{
    protected $fillable = [
        'user_id',
        'material_type',
        'date_schedule',
        'date_time',
        'status',
        'admin_notes',
    ];

    protected $casts = [
        'date_schedule' => 'date',
    ];

    // Relationship with user who made the request
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
