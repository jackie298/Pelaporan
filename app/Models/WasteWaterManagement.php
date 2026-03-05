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
        'sampler',        // Inlet / Outlet
        'cuaca',          // Kondisi cuaca
        'ph',
        'tss',
        'debit_air',      // Volume air
        'status_kesesuaian',
        'catatan',
        'created_by',
    ];

    protected $casts = [
        'tanggal_sampling' => 'date:Y-m-d',
        'ph'               => 'decimal:1',
        'tss'              => 'decimal:2',
        'debit_air'        => 'decimal:2',
        'deleted_at'       => 'datetime',
    ];

    /**
     * Relasi ke user yang membuat data
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Helper untuk label Sampler (Inlet/Outlet) agar lebih rapi di view
     */
    public function getSamplerLabelAttribute(): string
    {
        return ucfirst($this->sampler);
    }

    /**
     * Helper untuk menentukan warna badge status
     */
    public function getStatusBadgeAttribute(): string
    {
        return $this->status_kesesuaian === 'memenuhi' ? 'success' : 'danger';
    }
}