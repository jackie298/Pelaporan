<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class workhours extends Model
{
    use HasFactory;

    protected $fillable = [
        'alat_id',
        'tanggal',
        'jam_mulai',
        'jam_selesai',
        'jam_istirahat',
        'total_jam',
        'lokasi',
        'aktivitas',
        'catatan'
    ];

    protected $casts = [
        'tanggal' => 'date',
        'total_jam' => 'decimal:2'
    ];

    // Relasi
    public function alat()
    {
        return $this->belongsTo(Equipment::class, 'alat_id');
    }

}
