<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complience extends Model
{
    use HasFactory;

    protected $table = 'complience';

    /**
     * Kolom yang bisa diisi mass assignment.
     */
    protected $fillable = [
        'judul',
        'jenis',
        'nomor_dokumen',
        'tanggal_terbit',
        'tanggal_kadaluarsa',
        'status',
        'keterangan',
        'file_dokumen',
    ];

    /**
     * Kolom yang harus di-cast ke tipe tertentu.
     */
    protected $casts = [
        'tanggal_terbit' => 'date',
        'tanggal_kadaluarsa' => 'date',
    ];

    /**
     * Scope untuk dokumen yang akan kadaluarsa dalam 30 hari.
     */
    public function scopeAkanKadaluarsa($query)
    {
        return $query->whereBetween('tanggal_kadaluarsa', [now(), now()->addDays(30)])
                     ->where('status', 'Aktif');
    }

    /**
     * Scope untuk dokumen aktif.
     */
    public function scopeAktif($query)
    {
        return $query->where('status', 'Aktif');
    }
}