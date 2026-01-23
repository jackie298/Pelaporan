<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'kode',
        'jenis',
        'merk',
        'tahun',
        'no_polisi',
        'no_mesin',
        'status',
        'lokasi_sekarang',
        'catatan'
    ];

    protected $table = 'equipments';

    // Relasi ke workhours
    public function workhours()
    {
        return $this->hasMany(workhours::class, 'alat_id');
    }
}
