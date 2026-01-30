<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TrashManagement extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Nama tabel di database.
     */
    protected $table = 'trash_management';

    /**
     * Kolom yang bisa diisi mass assignment.
     */
    protected $fillable = [
        'jenis_limbah_masuk',
        'kode_limbah',
        'tanggal_masuk',
        'sumber_limbah',
        'jumlah_masuk_ton',
        'maksimal_penyimpanan',
        'tanggal_keluar',
        'jumlah_keluar_ton',
        'tujuan_penyerahan',
        'nomor_dokumen',
        'sisa_limbah_ton',
        'created_by',
    ];

    /**
     * Kolom yang harus di-cast ke tipe tertentu.
     */
    protected $casts = [
        'tanggal_masuk'        => 'date:Y-m-d',
        'maksimal_penyimpanan' => 'date:Y-m-d',
        'tanggal_keluar'       => 'date:Y-m-d',
        'jumlah_masuk_ton'     => 'decimal:2',
        'jumlah_keluar_ton'    => 'decimal:2',
        'sisa_limbah_ton'      => 'decimal:2',
        'created_at'           => 'datetime',
        'updated_at'           => 'datetime',
        'deleted_at'           => 'datetime',
    ];

    /**
     * Relasi: Data dimasukkan oleh User (Admin/Staff).
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Scope untuk filter berdasarkan Kode Limbah.
     */
    public function scopeKode($query, string $kode)
    {
        return $query->where('kode_limbah', $kode);
    }

    /**
     * Scope untuk mencari data yang belum keluar (masih di penyimpanan).
     */
    public function scopeMasihDisimpan($query)
    {
        return $query->whereNull('tanggal_keluar');
    }

    /**
     * Scope untuk filter berdasarkan rentang tanggal masuk.
     */
    public function scopeTanggalMasukAntara($query, string $dari, string $sampai)
    {
        return $query->whereBetween('tanggal_masuk', [$dari, $sampai]);
    }

    public function setJenisLimbahMasukAttribute($value)
    {
        $this->attributes['jenis_limbah_masuk'] = strtoupper(trim($value));
    }

    public function setKodeLimbahAttribute($value)
    {
        $this->attributes['kode_limbah'] = strtoupper(trim($value));
    }

    public function setTujuanPenyerahanAttribute($value)
    {
        $this->attributes['tujuan_penyerahan'] = strtoupper(trim($value));
    }

    public function setNomorDokumenAttribute($value)
    {
        $this->attributes['nomor_dokumen'] = strtoupper(trim($value));
    }
}