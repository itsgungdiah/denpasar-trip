<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Itinerary extends Model
{
    protected $fillable = [
        'trip_id',
        'destination_id',
        'date',
        'start_time',
        'duration',
        'note',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'date',
            'duration' => 'integer',
            'sort_order' => 'integer',
        ];
    }

    public function trip(): BelongsTo
    {
        return $this->belongsTo(Trip::class);
    }

    public function destination(): BelongsTo
    {
        return $this->belongsTo(Destination::class);
    }
}
