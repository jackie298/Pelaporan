<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Revegetasi extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Nama tabel di database.
     */
    protected $table = 'revegetasi';

    /**
     * Kolom yang bisa diisi mass assignment.
     */
    protected $fillable = [
        'tanggal_monitoring',
        'lokasi_revegetasi',
        'luas_area',
        'jenis_vegetasi',
        'jumlah_tanaman',
        'tingkat_keberhasilan',
        'kondisi_tanah',
        'metode_penanaman',
        'catatan',
        'created_by',
    ];

    /**
     * Kolom yang harus di-cast ke tipe tertentu.
     */
    protected $casts = [
        'tanggal_monitoring' => 'date:Y-m-d',
        'luas_area' => 'decimal:2',
        'jumlah_tanaman' => 'integer',
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
     * Scope untuk filter berdasarkan tingkat keberhasilan.
     */
    public function scopeKeberhasilan($query, string $tingkat)
    {
        return $query->where('tingkat_keberhasilan', $tingkat);
    }

    /**
     * Scope untuk filter berdasarkan rentang tanggal.
     */
    public function scopeTanggalAntara($query, string $dari, string $sampai)
    {
        return $query->whereBetween('tanggal_monitoring', [$dari, $sampai]);
    }
}