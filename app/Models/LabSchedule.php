<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LabSchedule extends Model
{
    use HasFactory;

    protected $fillable = ['location_id', 'keperluan', 'user_name', 'hari', 'waktu'];

    public function location(): BelongsTo
    {
        // Disinkronkan murni memanggil model Locations milikmu (pakai s)
        return $this->belongsTo(Location::class, 'location_id');
    }
}
