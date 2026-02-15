<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class Event extends Model
{
    protected $fillable = [
        'title',
        'description',
        'event_date',
        'event_time',
        'location',
        'event_image',
        'status',
    ];

    protected $casts = [
        'event_date' => 'date',
    ];

    /**
     * Scope to get upcoming events
     */
    public function scopeUpcoming($query)
    {
        // Check if required columns exist before querying
        if (Schema::hasColumn('events', 'status') && Schema::hasColumn('events', 'event_date')) {
            return $query->where('status', 'upcoming')
                ->where('event_date', '>=', now()->toDateString())
                ->orderBy('event_date', 'asc');
        }

        // Fallback: return empty query if columns don't exist
        return $query->whereRaw('1 = 0');
    }
}
