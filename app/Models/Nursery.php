<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Nursery extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'nursery';

    protected $fillable = [
        'jenis_tanaman',
        'jumlah_bibit',
        'tanggal_penyemaian',
        'lokasi_pembibitan',
        'status_pertumbuhan',
        'persentase_keberhasilan',
        'catatan',
        'estimasi_siap_tanam',
        'created_by',
    ];

    protected $casts = [
        'tanggal_penyemaian' => 'date:Y-m-d',
        'estimasi_siap_tanam' => 'date:Y-m-d',
        'persentase_keberhasilan' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function creator()
    {
        return $this->belongsTo(\App\Models\User::class, 'created_by');
    }
}