<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes; // Jika butuh soft delete

class Equipment extends Model
{
    use HasFactory;
    // use SoftDeletes; // Uncomment jika ingin soft delete

    protected $table = 'equipments';

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
        'catatan',
        'created_by',
    ];

    protected $casts = [
        'tahun' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Opsi status yang tersedia
     */
    public const STATUS_OPTIONS = [
        'tersedia' => 'Tersedia',
        'dipakai' => 'Dipakai',
        'perawatan' => 'Perawatan',
        'rusak' => 'Rusak',
        'tidak_aktif' => 'Tidak Aktif',
    ];

    /**
     * Scope: Filter berdasarkan status
     */
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope: Filter berdasarkan jenis (partial match)
     */
    public function scopeJenis($query, $jenis)
    {
        return $query->where('jenis', 'like', "%{$jenis}%");
    }

    /**
     * Scope: Search nama, kode, atau merk
     */
    public function scopeSearch($query, $keyword)
    {
        return $query->where(function($q) use ($keyword) {
            $q->where('nama', 'like', "%{$keyword}%")
              ->orWhere('kode', 'like', "%{$keyword}%")
              ->orWhere('merk', 'like', "%{$keyword}%");
        });
    }

    /**
     * Accessor: Format status untuk display
     */
    public function getStatusLabelAttribute()
    {
        return self::STATUS_OPTIONS[$this->status] ?? ucfirst($this->status);
    }

    /**
     * Accessor: Badge color untuk status
     */
    public function getStatusBadgeColorAttribute()
    {
        $colors = [
            'tersedia' => 'success',
            'dipakai' => 'info',
            'perawatan' => 'warning',
            'rusak' => 'danger',
            'tidak_aktif' => 'secondary',
        ];
        return $colors[$this->status] ?? 'secondary';
    }

    /**
     * Relasi: Creator (user yang membuat)
     */
    public function creator()
    {
        return $this->belongsTo(\App\Models\User::class, 'created_by');
    }
}