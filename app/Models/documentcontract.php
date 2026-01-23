<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentContract extends Model
{
    use HasFactory;

    protected $table = 'document_contracts';

    protected $fillable = [
        'nama',
        'realisasi',
        'keterangan_jasa',
        'harga',
        'status',
        'keterangan',
        'uraian_rkab',
        'file_kontrak',
    ];
}
