<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Asset extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Relasi ke model Location (Satu aset berada di satu ruangan lab)
     */
    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    /**
     * Relasi ke model Maintenance (Satu aset bisa memiliki banyak riwayat perbaikan)
     */
    public function maintenances(): HasMany
    {
        return $this->hasMany(Maintenance::class);
    }
}