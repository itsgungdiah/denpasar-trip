<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Destination extends Model
{
    protected $fillable = [
        'name',
        'description',
        'image',
        'opening_hours',
        'entrance_fee',
        'average_spending',
        'google_maps_url',
    ];

    protected function casts(): array
    {
        return [
            'opening_hours' => 'array',
            'entrance_fee' => 'array',
            'average_spending' => 'array',
        ];
    }

    /**
     * Normalize legacy opening-hours values that were JSON-encoded twice.
     * New values continue to use Laravel's array cast when they are stored.
     */
    protected function openingHours(): Attribute
    {
        return Attribute::make(get: function ($value): array {
            for ($attempt = 0; $attempt < 2 && is_string($value); $attempt++) {
                $decoded = json_decode($value, true);

                if (json_last_error() !== JSON_ERROR_NONE) {
                    return [];
                }

                $value = $decoded;
            }

            return is_array($value) ? $value : [];
        });
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function itineraries(): HasMany
    {
        return $this->hasMany(Itinerary::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }
}
