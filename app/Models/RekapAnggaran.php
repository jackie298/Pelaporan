<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class RekapAnggaran extends Model
{
    use HasFactory;

    protected $table = 'rekap_anggaran';

    protected $fillable = [
        'nama',
        'realisasi',
        'keterangan_jasa',
        'harga',
        'status',
        'periode',
        'keterangan',
        'uraian_rkab',
        'file_kontrak',
    ];

    /**
     * Casting kolom agar otomatis menjadi objek Carbon/Tanggal
     */
    protected $casts = [
        'periode' => 'date',
    ];

    /**
     * Logika otomatisasi saat model dibuat
     */
    protected static function booted()
    {
        static::creating(function ($rekap) {
            // Jika periode tidak diisi manual, maka otomatis diisi tanggal hari ini
            if (empty($rekap->periode)) {
                $rekap->periode = Carbon::now()->format('Y-m-d');
            }
        });
    }
}