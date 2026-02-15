<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
        return $query->where('status', 'upcoming')
            ->where('event_date', '>=', now()->toDateString())
            ->orderBy('event_date', 'asc');
    }
}
