<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MonitoringVegetasi extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Nama tabel di database.
     */
    protected $table = 'monitoring_vegetasi';

    /**
     * Kolom yang bisa diisi mass assignment.
     */
    protected $fillable = [
        'lokasi',
        'titik_pantau',
        'jenis_tanaman',
        'tinggi_triwulan1',
        'tinggi_triwulan2',
        'tinggi_triwulan3',
        'tinggi_triwulan4',
        'tahun',
        'catatan',
        'created_by',
    ];

    /**
     * Kolom yang harus di-cast ke tipe tertentu.
     */
    protected $casts = [
        'tinggi_triwulan1' => 'decimal:2',
        'tinggi_triwulan2' => 'decimal:2',
        'tinggi_triwulan3' => 'decimal:2',
        'tinggi_triwulan4' => 'decimal:2',
        'tahun' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Relasi ke user yang membuat data.
     */
    public function creator()
    {
        return $this->belongsTo(\App\Models\User::class, 'created_by');
    }

    /**
     * Scope untuk filter berdasarkan lokasi.
     */
    public function scopeLokasi($query, $lokasi)
    {
        return $query->where('lokasi', 'like', "%{$lokasi}%");
    }

    /**
     * Scope untuk filter berdasarkan jenis tanaman.
     */
    public function scopeJenisTanaman($query, $jenis)
    {
        return $query->where('jenis_tanaman', 'like', "%{$jenis}%");
    }

    /**
     * Scope untuk data aktif (belum dihapus).
     */
    public function scopeAktif($query)
    {
        return $query->whereNull('deleted_at');
    }
}