<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Statistic extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'key',
        'label',
        'value',
        'icon',
        'order',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Scope a query to only include active statistics.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to order statistics by custom order.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }

    /**
     * Get statistic by key.
     */
    public static function getByKey($key)
    {
        return self::where('key', $key)->first()?->value ?? 0;
    }

    /**
     * Update statistic value by key.
     */
    public static function updateByKey($key, $value)
    {
        return self::where('key', $key)->update(['value' => $value]);
    }
}
