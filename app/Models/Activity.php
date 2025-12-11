<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $fillable = [
        'activity_date',
        'time_start',
        'time_end',
        'title',
        'description',
        'location',
        'max_participants',
        'current_participants',
        'image',
        'has_image',
        'category',
        'is_published',
    ];

    protected $casts = [
        'activity_date' => 'date',
        'has_image' => 'boolean',
        'is_published' => 'boolean',
        'max_participants' => 'integer',
        'current_participants' => 'integer',
    ];

    // Check if activity has available slots
    public function hasAvailableSlots()
    {
        if (!$this->max_participants) {
            return true; // No limit set
        }
        return $this->current_participants < $this->max_participants;
    }

    // Get remaining slots
    public function getRemainingSlots()
    {
        if (!$this->max_participants) {
            return null; // No limit
        }
        return max(0, $this->max_participants - $this->current_participants);
    }
}
