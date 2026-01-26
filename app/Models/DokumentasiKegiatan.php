<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DokumentasiKegiatan extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Nama tabel di database.
     */
    protected $table = 'dokumentasi_kegiatan';


    /**
     * Kolom yang bisa diisi
     */
    protected $fillable = [
        'judul',
        'tanggal',
        'lokasi',
        'deskripsi',
        'jenis_kegiatan',
        'file_dokumentasi', // path file (foto/laporan)
        'created_by',       // ID user yang membuat
    ];

    /**
     * Kolom yang harus di-cast ke tipe tertentu.
     */
    protected $casts = [
        'tanggal' => 'date:Y-m-d',
        'file_dokumentasi' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Relasi: Dokumentasi dibuat oleh User.
     */
    public function creator()
    {
        return $this->belongsTo(\App\Models\User::class, 'created_by');
    }

    /**
     * Scope untuk filter berdasarkan jenis kegiatan.
     */
    public function scopeJenis($query, $jenis)
    {
        return $query->where('jenis_kegiatan', $jenis);
    }

    /**
     * Scope untuk filter berdasarkan rentang tanggal.
     */
    public function scopeTanggalAntara($query, $dari, $sampai)
    {
        return $query->whereBetween('tanggal', [$dari, $sampai]);
    }
}
