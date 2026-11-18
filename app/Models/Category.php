<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany; /* menentukan tipe relasi, belongsToMany artinya Many-to-Many */

class Category extends Model
{
    public const DESTINATION_NAMES = [
        'Culture',
        'Culinary',
        'Shopping',
        'Nature',
        'Art',
    ];

    public function destinations(): BelongsToMany
    {
        return $this->belongsToMany(Destination::class);
    }
}
