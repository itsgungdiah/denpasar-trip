<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Trip extends Model
{
    protected $fillable = [
        'trip_name',
        'start_date',
        'end_date',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
        ];
    }

    public function calculateDuration(): int
    {
        $startDate = $this->start_date;
        $endDate = $this->end_date;

        if (! $startDate || ! $endDate) {
            return 0;
        }

        return max(0, (int) $startDate->diffInDays($endDate, false) + 1);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function preferences(): HasMany
    {
        return $this->hasMany(TripPreference::class);
    }

    public function itineraries(): HasMany
    {
        return $this->hasMany(Itinerary::class);
    }
}
