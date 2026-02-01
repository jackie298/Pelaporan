<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Compliance extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'compliance';

    protected $fillable = [
        'Nama_pelapor',
        'Departemen',
        'Lokasi',
        'Jenis_insiden',
        'Jenis_inspeksi',
        'Tanggal_lapor',
        'Status',
        'Tingkat_keparahan',
        'Diselesaikan_oleh',
        'file_dokumentasi',
    ];

    protected $casts = [
        'Tanggal_lapor' => 'date:Y-m-d',
        'file_dokumentasi' => 'array', // ← Casting ke array
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function scopeStatus($query, $status)
    {
        return $query->where('Status', $status);
    }

    public function scopeTingkatKeparahan($query, $tingkat_keparahan)
    {
        return $query->where('Tingkat_keparahan', $tingkat_keparahan);
    }

    public function scopeDepartemen($query, $departemen)
    {
        return $query->where('Departemen', $departemen);
    }

    public function scopeLokasi($query, $lokasi)
    {
        return $query->where('Lokasi', $lokasi);
    }
}