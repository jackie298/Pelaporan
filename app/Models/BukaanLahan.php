<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BukaanLahan extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Nama tabel di database.
     */
    protected $table = 'bukaan_lahan';

    /**
     * Kolom yang bisa diisi mass assignment.
     */
    protected $fillable = [
        'tanggal_bukaan',
        'lokasi_bukaan',
        'luas_dibuka',
        'jenis_vegetasi_awal',
        'metode_pembukaan',
        'alat_berat_digunakan',
        'izin_lingkungan',
        'status_kesesuaian',
        'created_by',
    ];

    /**
     * Kolom yang harus di-cast ke tipe tertentu.
     */
    protected $casts = [
        'tanggal_bukaan' => 'date:Y-m-d',
        'luas_dibuka' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Relasi: Data dimasukkan oleh User.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Scope untuk filter berdasarkan status kesesuaian.
     */
    public function scopeStatus($query, string $status)
    {
        return $query->where('status_kesesuaian', $status);
    }

    /**
     * Scope untuk filter berdasarkan rentang tanggal.
     */
    public function scopeTanggalAntara($query, string $dari, string $sampai)
    {
        return $query->whereBetween('tanggal_bukaan', [$dari, $sampai]);
    }
}