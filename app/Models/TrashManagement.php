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
        'tanggal',
        'sumber_sampah',
        'sampah_organik_terpilah',
        'sampah_anorganik_terpilah',
        'sampah_lainnya_dan_atau_residu',
        'total',
        'created_by',
    ];

    /**
     * Kolom yang harus di-cast ke tipe tertentu.
     */
    protected $casts = [
        'tanggal' => 'date:Y-m-d',
        'sampah_organik_terpilah' => 'integer',
        'sampah_anorganik_terpilah' => 'integer',
        'sampah_lainnya_dan_atau_residu' => 'integer',
        'total' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Opsi nilai untuk enum sumber_sampah
     * Digunakan untuk dropdown di form
     */
    public const SUMBER_SAMPAH_OPTIONS = [
        'area kantor' => 'Area Kantor',
        'area site' => 'Area Site',
    ];

    /**
     * Relasi: Data dimasukkan oleh User.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Scope untuk filter berdasarkan sumber sampah.
     */
    public function scopeSumber($query, string $sumber)
    {
        return $query->where('sumber_sampah', $sumber);
    }

    /**
     * Scope untuk filter berdasarkan rentang tanggal.
     */
    public function scopeTanggalAntara($query, string $dari, string $sampai)
    {
        return $query->whereBetween('tanggal', [$dari, $sampai]);
    }

    /**
     * Scope untuk filter berdasarkan tanggal tertentu.
     */
    public function scopeTanggal($query, string $tanggal)
    {
        return $query->whereDate('tanggal', $tanggal);
    }

    /**
     * Accessor untuk label sumber sampah yang mudah dibaca.
     */
    public function getSumberSampahLabelAttribute(): string
    {
        if (empty($this->sumber_sampah)) {
            return '-';
        }
        
        return self::SUMBER_SAMPAH_OPTIONS[$this->sumber_sampah] ?? $this->sumber_sampah;
    }

    /**
     * Accessor untuk format tanggal yang user-friendly.
     */
    public function getTanggalFormattedAttribute(): string
    {
        return $this->tanggal ? $this->tanggal->format('d/m/Y') : '-';
    }

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        // Hitung ulang total sebelum menyimpan
        static::saving(function ($model) {
            $model->total = ($model->sampah_organik_terpilah ?? 0) + 
                            ($model->sampah_anorganik_terpilah ?? 0) + 
                            ($model->sampah_lainnya_dan_atau_residu ?? 0);
        });
    }

    
}