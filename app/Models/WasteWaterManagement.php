<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WasteWaterManagement extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'waste_water_management';

    protected $fillable = [
        'tanggal_sampling',
        'lokasi_sampling',
        'ph',
        'tss',
        'status_kesesuaian',
        'catatan',
        'created_by',
    ];

    protected $casts = [
        'tanggal_sampling' => 'date:Y-m-d',
        'ph' => 'decimal:1',
        'tss' => 'decimal:2',
        'deleted_at' => 'datetime',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}