<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reklamasi extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Nama tabel di database.
     */
    protected $table = 'reklamasi';

    /**
     * Kolom yang bisa diisi mass assignment.
     */
    protected $fillable = [
        'tanggal_reklamasi',
        'lokasi_reklamasi',
        'luas_direklamasi',
        'jenis_kegiatan',
        'metode_reklamasi',
        'alat_berat_digunakan',
        'izin_lingkungan',
        'status_kesesuaian',
        'catatan',
        'created_by',
    ];

    /**
     * Kolom yang harus di-cast ke tipe tertentu.
     */
    protected $casts = [
        'tanggal_reklamasi' => 'date:Y-m-d',
        'luas_direklamasi' => 'decimal:2',
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
        return $query->whereBetween('tanggal_reklamasi', [$dari, $sampai]);
    }
}