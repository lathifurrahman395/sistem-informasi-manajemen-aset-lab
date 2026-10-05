<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Maintenance extends Model
{
    protected $fillable = ['asset_id', 'deskripsi_kerusakan', 'teknisi', 'biaya', 'tanggal_mulai', 'tanggal_selesai', 'status'];

    public function asset(): BelongsTo
    {
        return $this->belongsTo(Asset::class);
    }
}