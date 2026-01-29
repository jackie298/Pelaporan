<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RencanaRevegetasi extends Model
{
    use HasFactory;

    // Menentukan nama tabel secara eksplisit sesuai file migrasi Anda
    protected $table = 'rencana_revegetasis';

    // Kolom yang boleh diisi secara massal
    protected $fillable = [
        'tahun',
        'bulan',
        'target_bibit',
        'lokasi',
    ];

    // Casting tipe data agar lebih mudah dikelola di Controller
    protected $casts = [
        'tahun' => 'integer',
        'bulan' => 'integer',
        'target_bibit' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Helper untuk mendapatkan nama bulan dalam Bahasa Indonesia
     */
    public function getNamaBulanAttribute()
    {
        $bulan = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];

        return $bulan[$this->bulan] ?? 'Unknown';
    }
}