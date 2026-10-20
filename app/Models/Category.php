<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany; /* menentukan tipe relasi, belongsToMany artinya Many-to-Many */

class Category extends Model
{   /* membuat fungsi untuk relasi destinations yang bisa dipanggil dari model category */
    public function destinations(): BelongsToMany
    {   /* menghubungkan kategori dengan banyak destinasi melalui tabel pivot */
        return $this->belongsToMany(Destination::class); /* menujukkan hubungan dengan model destination */
    }
}
